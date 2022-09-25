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
                <td>John Doe</td>
            </tr>
            <tr>
                <td>Username</td>
                <td>:</td>
                <td>johndoe</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>:</td>
                <td><span class="badge text-dark bg-warning">SISWA</span></td>
            </tr>
            <tr>
                <td>Last login</td>
                <td>:</td>
                <td class="text-primary">2022-09-23</td>
            </tr>
        </tbody>
    </table>
@endsection