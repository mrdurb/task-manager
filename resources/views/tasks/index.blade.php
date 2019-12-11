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
                    <button class="btn btn-primary" id="editTask" onclick="window.location.replace('http://127.0.0.1:8000/tasks/{{$task->id}}/edit')">Редактировать</button>
                    <button class="btn btn-danger" onclick="window.location.replace('http://127.0.0.1:8000/tasks/{{$task->id}}/delete')">Удалить</button>
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
<button class="btn btn-success float-right mb-3" id="addTask">Добавить</button>
</div>
<script>
    var addTaskModal = new jBox('Modal', {
        attach: '#addTask',
        title: '<h4>Добавить задачу</h4>',
        content: `  <form id="taskForm" method="POST" action="/tasks" class="addForm">
                        {{ csrf_field() }}
                        <div class="input-group input-group-lg mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Название</span>
                            </div>
                            <input type="text" class="form-control" name="title" required />
                        </div>
                        <div class="input-group input-group-lg mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Исполнитель</span>
                            </div>
                            <select name="employee" class="custom-select" required>
                                <option selected value="">Выберите сотрудника</option>
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
                            <select name="status" class="custom-select" required>
                                <option selected value="Открыта">Открыта</option>
                                <option value="В работе">В работе</option>
                                <option value="Завершена">Завершена</option>
                            </select>
                        </div>
                        <button class="btn btn-danger float-right mt-3" onclick="addTaskModal.close();">Отмена</button>
                        <button class="btn btn-success float-right mr-1 mt-3" type="submit">Сохранить</button>
                    </form>`
    });

    // var editTaskModal = new jBox('Modal', {
    //     attach: '#editTask',
    //     title: '<h4>Редактировать задачу</h4>',
    //     content: `  <div class="input-group input-group-lg mb-4">
    //                     <div class="input-group-prepend">
    //                         <span class="input-group-text">Название</span>
    //                     </div>
    //                     <input type="text" class="form-control">
    //                 </div>
    //                 <div class="input-group input-group-lg mb-4">
    //                     <div class="input-group-prepend">
    //                         <span class="input-group-text">Исполнитель</span>
    //                     </div>
    //                     <input type="text" class="form-control">
    //                 </div>
    //                 <div class="input-group input-group-lg mb-4">
    //                     <div class="input-group-prepend">
    //                         <span class="input-group-text">Статус</span>
    //                     </div>
    //                     <input type="text" class="form-control">
    //                 </div>
    //                 <button class="btn btn-danger float-right" onclick="editTaskModal.close();">Отмена</button>
    //                 <button class="btn btn-success float-right mr-1">Сохранить</button>`
    // });
</script>
@endsection