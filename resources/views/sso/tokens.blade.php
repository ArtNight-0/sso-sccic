@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Personal Access Tokens</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>User ID</th>
                    <th>Revoked</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tokens as $token)
                    <tr>
                        <td>{{ $token->id }}</td>
                        <td>{{ $token->client->name }}</td>
                        <td>{{ $token->user_id }}</td>
                        <td>{{ $token->revoked ? 'Yes' : 'No' }}</td>
                        <td>
                            @if (!$token->revoked)
                                <form action="{{ route('tokens.revoke', $token->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-warning">Revoke</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
