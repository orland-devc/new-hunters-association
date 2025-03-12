<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discord Time In Records</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --discord-primary: #5865F2;
            --discord-dark: #2F3136;
            --discord-darker: #202225;
            --discord-light: #F6F6F6;
            --discord-success: #57F287;
        }
        
        body {
            background-color: var(--discord-light);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            color: var(--discord-dark);
        }
        
        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        
        .card-header {
            background-color: var(--discord-primary);
            color: white;
            font-weight: 700;
            padding: 1.2rem 1.5rem;
            border-bottom: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table th {
            font-weight: 600;
            border-top: none;
            background-color: #f8f9fa;
            color: #495057;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }
        
        .table td, .table th {
            padding: 1rem 1.5rem;
            vertical-align: middle;
        }
        
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.02);
        }
        
        .badge-active {
            background-color: var(--discord-success);
            color: white;
            font-weight: 500;
            padding: 0.4rem 0.8rem;
            border-radius: 12px;
            display: inline-block;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .user-avatar img {
            width: 32px;
            height: 32px;
            background-color: #DDD;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 14px;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background-color: #DDD;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 14px;
        }
        
        .timestamp {
            color: #6c757d;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-clock me-2"></i>
                <h5 class="mb-0">Discord Time In Records</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>User ID</th>
                                <th>Time In</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($timeRecords as $record)
                                <tr>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                @if (!$record->discord_avatar)
                                                    <i class="fas fa-user"></i>
                                                @else
                                                    <img src="https://cdn.discordapp.com/avatars/{{ $record->discord_user_id }}/{{ $record->discord_avatar }}.png" alt="">
                                                @endif
                                            </div>
                                            <span>{{ $record->discord_username }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $record->discord_user_id }}</td>
                                    <td>
                                        <span class="timestamp">
                                            {{ \Carbon\Carbon::parse($record->time_in)->format('F j, h:i A') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($record->time_out)
                                            <span class="timestamp">
                                                {{ \Carbon\Carbon::parse($record->time_out)->format('F j, h:i A') }}
                                            </span>
                                        @else
                                            <span class="badge-active">
                                                <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                                Active
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>