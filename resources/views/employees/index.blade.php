@extends('layout')

@section('employees_table')
<div class="table-responsive">
    <table id="employees_table" class="table table-bordered">
        <thead>
            <tr>
                <th>id</th>
                <th>Имя</th>
                <th>Должность</th>
                <th>Действие</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employees as $employee)
            <tr>
                <td>{{ $employee->id }}</td>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->position }}</td>
                <td>
                    <button class="btn btn-primary">Редактировать</button>
                    <button class="btn btn-danger">Удалить</button>
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="2">Нет записей</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection