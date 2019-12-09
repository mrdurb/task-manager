@extends('layout')

@section('tasks_table')
<div class="table-responsive">
    <table id="tasks_table" class="table table-bordered">
        <thead>
            <tr>
                <th>id</th>
                <th>Название</th>
                <th>Исполнитель</th>
                <th>Статус</th>
                <th>Действие</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->title }}</td>
                <td>{{ $task->employee }}</td>
                <td>{{ $task->status }}</td>
                <td>
                    <button class="btn btn-primary" id="editTask">Редактировать</button>
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
<button class="btn btn-success float-right" id="addTask">Добавить</button>
</div>
<script>
    var addTaskModal = new jBox('Modal', {
        attach: '#addTask',
        title: '<h4>Добавить задачу</h4>',
        content: `  <div class="input-group input-group-lg mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Название</span>
                        </div>
                        <input type="text" class="form-control">
                    </div>
                    <div class="input-group input-group-lg mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Исполнитель</span>
                        </div>
                        <input type="text" class="form-control">
                    </div>
                    <div class="input-group input-group-lg mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Статус</span>
                        </div>
                        <input type="text" class="form-control">
                    </div>
                    <button class="btn btn-danger float-right" onclick="addTaskModal.close();">Отмена</button>
                    <button class="btn btn-success float-right mr-1">Сохранить</button>`
    });

    var editTaskModal = new jBox('Modal', {
        attach: '#editTask',
        title: '<h4>Редактировать задачу</h4>',
        content: `  <div class="input-group input-group-lg mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Название</span>
                        </div>
                        <input type="text" class="form-control">
                    </div>
                    <div class="input-group input-group-lg mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Исполнитель</span>
                        </div>
                        <input type="text" class="form-control">
                    </div>
                    <div class="input-group input-group-lg mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Статус</span>
                        </div>
                        <input type="text" class="form-control">
                    </div>
                    <button class="btn btn-danger float-right" onclick="editTaskModal.close();">Отмена</button>
                    <button class="btn btn-success float-right mr-1">Сохранить</button>`
    });
</script>
@endsection