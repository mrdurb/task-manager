@extends('layout')

@section('editTask')
<form id="taskForm" method="POST" action="/tasks/{{ $task->id }}" class="editForm">
    {{ csrf_field() }}
    @method('PUT')
    <div class="input-group input-group-lg mb-4">
        <div class="input-group-prepend">
            <span class="input-group-text">Название</span>
        </div>
        <input type="text" class="form-control" name="title" value="{{ $task->title }}" required />
    </div>
    <div class="input-group input-group-lg mb-4">
        <div class="input-group-prepend">
            <span class="input-group-text">Исполнитель</span>
        </div>
        <select name="employee" class="custom-select" required>
            <option value="{{ $task->employee }}">Выберите сотрудника</option>
            @forelse($employees as $employee)
                <option value="{{ $employee->name }}">{{ $employee->name }}</option>
            @empty
                <option selected value="">Никого нет</option>
            @endforelse
        </select>
    </div>
    <div class="input-group input-group-lg mb-4">
        <div class="input-group-prepend">
            <span class="input-group-text">Статус</span>
        </div>
        <select name="status" class="custom-select" value="{{ $task->status }}" required>
            <option value="Открыта">Открыта</option>
            <option value="В работе">В работе</option>
            <option value="Завершена">Завершена</option>
        </select>
    </div>
    <a class="btn btn-danger float-right text-white" onclick="window.location.replace('http://127.0.0.1:8000/tasks')">Отмена</a>
    <button class="btn btn-success float-right mr-1" type="submit">Сохранить</button>
</form>
@endsection