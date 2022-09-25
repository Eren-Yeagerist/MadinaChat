@extends('layouts.main')
@section('title'){{ 'Profile' }}@endsection
@section('content')
    <h3 class="mb-3">Profile <i class="fa-regular fa-user"></i></h3>
    <table class="table">
        <thead class="table-dark">
            <th class="text-center" colspan="3"></th>
        </thead>
        <tbody>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <td>Username</td>
                <td>:</td>
                <td>{{ $user->username }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>:</td>
                <td>
                    @if (auth()->user()->role() == 'staff')
                        <span class="badge bg-success">STAFF</span>
                    @elseif (auth()->user()->role() == 'admin')
                        <span class="badge bg-warning">ADMIN</span>
                    @elseif (auth()->user()->role() == 'user')
                        <span class="badge bg-primary">USER</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td>Last login</td>
                <td>:</td>
                <td class="text-primary">2022-09-23</td>
            </tr>
        </tbody>
    </table>
@endsection