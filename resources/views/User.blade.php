<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>

    <div class="admin-actions">
        <h2>Manage Institutions</h2>
        <ul>
            <li><a href="{{ route('admin.institutions.create') }}">Add Institution</a></li>
            <li><a href="{{ route('admin.applications.index') }}">View Applications</a></li>
        </ul>

        <h2>Manage Faculties</h2>
        <ul>
            <li><a href="{{ route('admin.faculties.create') }}">Add Faculty</a></li>
        </ul>

        <h2>Manage Courses</h2>
        <ul>
            <li><a href="{{ route('admin.courses.create') }}">Add Course</a></li>
        </ul>
    </div>
</div>
</body>
</html>