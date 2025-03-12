<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiscordTimeIn;
use Laravel\Passport\PersonalAccessTokenFactory;
use Laravel\Passport\TokenRepository;
use Illuminate\Support\Facades\DB;

class DiscordTimeInController extends Controller
{
    public function index()
    {
        $timeRecords = DiscordTimeIn::all();
        return view('discord_time_in.index', compact('timeRecords'));
    }
    
    public function store(Request $request, PersonalAccessTokenFactory $tokenFactory, TokenRepository $tokenRepository)
    {
        $request->validate([
            'discord_user_id' => 'required|string',
            'discord_username' => 'required|string',
            'discord_avatar' => 'nullable|string',
            'discord_discriminator' => 'nullable|string',
        ]);

        $discordUserId = $request->discord_user_id;
        $discordUsername = $request->discord_username;
        $discordAvatar = $request->discord_avatar;
        $discordDiscriminator = $request->discord_discriminator;

        // Check if user already has an active time-in today
        $existingTimeIn = DiscordTimeIn::where('discord_user_id', $discordUserId)
            ->whereDate('time_in', now()->toDateString())
            ->whereNull('time_out')
            ->latest()
            ->first();

        if ($existingTimeIn) {
            return response()->json(['message' => 'User already timed in today!'], 400);
        }

        // Check for existing valid token for this Discord user
        $existingToken = DB::table('oauth_access_tokens')
            ->where('discord_user_id', $discordUserId)
            ->where('revoked', 0)
            ->where('expires_at', '>', now())
            ->first();

        $tokenString = null;

        if ($existingToken) {
            // Reuse existing token
            $tokenString = $existingToken->id;
        } else {
            // Generate a new token
            $token = $tokenFactory->make(
                auth()->guard('api')->user(),
                'Discord API Token'
            );

            // Update the token with the discord_user_id
            DB::table('oauth_access_tokens')
                ->where('id', $token->token->id)
                ->update(['discord_user_id' => $discordUserId]);

            $tokenString = $token->accessToken;
        }

        // Save the time-in entry
        $timeIn = DiscordTimeIn::create([
            'discord_user_id' => $discordUserId,
            'discord_username' => $discordUsername,
            'discord_avatar' => $discordAvatar,
            'discord_discriminator' => $discordDiscriminator,
            'time_in' => now(),
            'time_out' => null,
        ]);

        return response()->json([
            'message' => 'Time-in recorded successfully!',
            'token' => $tokenString,
            'time_in' => $timeIn->time_in
        ]);
    }

    public function show($id)
    {
        $record = DiscordTimeIn::find($id);
        if (!$record) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        return response()->json($record);
    }

    public function update(Request $request, $id)
    {
        $record = DiscordTimeIn::find($id);
        if (!$record) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        $validated = $request->validate([
            'discord_user_id' => 'sometimes|string',
            'discord_username' => 'sometimes|string',
            'time_in' => 'sometimes|date',
            'time_out' => 'sometimes|nullable|date'
        ]);

        $record->update($validated);
        return response()->json($record);
    }

    public function destroy($id)
    {
        $record = DiscordTimeIn::find($id);
        if (!$record) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        $record->delete();
        return response()->json(['message' => 'Record deleted successfully']);
    }

    public function timeOut(Request $request)
    {
        $request->validate([
            'discord_user_id' => 'required|string',
        ]);

        $discordUserId = $request->discord_user_id;

        $timeInRecord = DiscordTimeIn::where('discord_user_id', $discordUserId)
            ->whereNull('time_out')
            ->latest()
            ->first();

        if (!$timeInRecord) {
            return response()->json(['message' => 'No active time-in found!'], 400);
        }

        $timeInRecord->update(['time_out' => now()]);

        return response()->json([
            'message' => 'Time-out recorded successfully!',
            'time_out' => $timeInRecord->time_out
        ]);
    }
}
