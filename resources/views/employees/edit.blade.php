@extends('layout')

@section('editEmployee')
<form id="employeeForm" method="POST" action="/employees/{{ $employee->id }}" class="editForm">
    {{ csrf_field() }}
    @method('PUT')
    <div class="input-group input-group-lg mb-4">
        <div class="input-group-prepend">
            <span class="input-group-text">Имя</span>
        </div>
        <input type="text" class="form-control" name="name" value="{{ $employee->name }}" required>
    </div>
    <div class="input-group input-group-lg mb-4">
        <div class="input-group-prepend">
            <span class="input-group-text">Должность</span>
        </div>
        <input type="text" class="form-control" name="position" value="{{ $employee->position }}" required>
    </div>
    <button class="btn btn-danger float-right" onclick="window.location.replace('http://127.0.0.1:8000/employees')">Отмена</button>
    <button class="btn btn-success float-right mr-1" type="submit">Сохранить</button>
</form>
@endsection