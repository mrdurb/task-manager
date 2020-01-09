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
            <tr id="task_{{ $task->id }}">
                <td>{{ $task->id }}</td>
                <td>{{ $task->title }}</td>
                <td>{{ $task->employee }}</td>
                <td>{{ $task->status }}</td>
                <td>
                <!-- onclick="window.location.replace('http://127.0.0.1:8000/tasks/{{$task->id}}/edit')" -->
                    <button class="btn btn-primary" id="editTask" onclick="formGetTask('{{ $task->id }}');">Редактировать</button>
                    <button class="btn btn-danger delete-link" onclick="formDelete('{{ $task->id }}');">Удалить</button>
                </td>
            </tr>
            @empty
            
            @endforelse
        </tbody>
    </table>
</div>
<button class="btn btn-success float-right mb-3" id="addTask" name="btn-add">Добавить</button>
</div>
<script>

    var addTaskModal = new jBox('Modal', {
        attach: '#addTask',
        title: '<h4>Добавить задачу</h4>',
        content: `  <form id="taskForm" class="addForm">
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
                            <select name="employee" class="custom-select" required >
                                <option value>Выберите сотрудника</option>
                                @forelse($employees as $employee)
                                    <option value="{{ $employee->name }} {{ $employee->id }}">{{ $employee->name }}</option>
                                @empty
                                    <option value>Никого нет</option>
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
                        <button class="btn btn-danger float-right mt-3" onclick="addTaskModal.close();" type="button">Отмена</button>
                        <button class="btn btn-success float-right mr-1 mt-3" type="button" id="btn-save" onclick="formSave(window.event);">Сохранить</button>
                    </form>`
    });

    var addConfirm = new jBox('Modal', {
        title: '<h4>Задача добавлена!</h4>',
        content: `<button class="btn btn-success float-right mr-1" type="button" onclick="addConfirm.close();">ОК</button>`
    });

    var editTaskModal;

    function formSave(e) {  
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        e.preventDefault();
        taskData = {
            title: $('input[name = "title"]').val(),
            employee: $('select[name = "employee"]').val().split(' ')[0],
            employee_id: $('select[name = "employee"]').val().split(' ')[1],
            status: $('select[name = "status"]').val(),
        };
        $.ajax({
            type:       'POST',
            url:        'tasks',
            data:       taskData,
            dataType:   'json',

            success: function (data) {  
                task = `<tr id="task_${data.id}">
                                <td>${data.id}</td>
                                <td>${data.title}</td>
                                <td>${data.employee}</td>
                                <td>${data.status}</td>
                                <td>
                                    <button class="btn btn-primary" id="editTask" onclick="formGetTask(${data.id});">Редактировать</button>
                                    <button class="btn btn-danger delete-link" onclick="formDelete(${data.id});">Удалить</button>
                                </td>
                            </tr>`
                $('#tasks_table').append(task);
                $('#taskForm').trigger("reset");
                addTaskModal.close();
                addConfirm.open();
            },
            error: function (data) {
                if (data.responseJSON.errors.title)
                    $('input[name = "title"]').addClass('border-danger');
                if (data.responseJSON.errors.employee)
                    $('select[name = "employee"]').addClass('border-danger');
                if (data.responseJSON.errors.status)
                    $('select[name = "status"]').addClass('border-danger');
                console.log('Error:', data.responseJSON.errors);
            }
        });
    }; 

    function formGetTask(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:   'GET',
            url:    `/tasks/${id}/edit`,
            
            success: function (data) {
                editTaskModal = new jBox('Modal', {
                    title: '<h4>Редактировать задачу</h4>',
                    content: `  <form id="taskForm" class="editForm">
                                    <div class="input-group input-group-lg mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Название</span>
                                        </div>
                                        <input type="text" class="form-control" name="title" value="${data.title}" required />
                                    </div>
                                    <div class="input-group input-group-lg mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Исполнитель</span>
                                        </div>
                                        <select name="employee" class="custom-select" required >
                                            <option selected value>Выберите сотрудника</option>
                                            @forelse($employees as $employee)
                                                <option value="{{ $employee->name }} {{ $employee->id }}">{{ $employee->name }}</option>
                                            @empty
                                                <option value>Никого нет</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="input-group input-group-lg mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Статус</span>
                                        </div>
                                        <select name="status" class="custom-select" value="${data.status}" required>
                                            <option value="Открыта">Открыта</option>
                                            <option value="В работе">В работе</option>
                                            <option value="Завершена">Завершена</option>
                                        </select>
                                    </div>
                                    <button class="btn btn-danger float-right mt-3" onclick="editTaskModal.destroy();" type="button">Отмена</button>
                                    <button class="btn btn-success float-right mr-1 mt-3" type="button" id="btn-save" onclick="formEditSave(window.event, ${data.id}, 'PUT');">Сохранить</button>
                                </form>`,
                    closeOnEsc: false,
                    closeOnClick: false, 
                    closeOnMouseleave: false,
                    closeButton: false
                });
                editTaskModal.open();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    };

    function formEditSave(e, id, method) {  
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        e.preventDefault();
        taskData = {
            title: $('input[name = "title"]').val(),
            employee: $('select[name = "employee"]').val().split(' ')[0],
            employee_id: $('select[name = "employee"]').val().split(' ')[1],
            status: $('select[name = "status"]').val(),
        };
        $.ajax({
            type:       method,
            url:        `/tasks/${id}/`,
            data:       taskData,
            dataType:   'json',

            success: function (data) {  
                $(`#task_${data.id}`).remove();
                task = `<tr id="task_${data.id}">
                                <td>${data.id}</td>
                                <td>${data.title}</td>
                                <td>${data.employee}</td>
                                <td>${data.status}</td>
                                <td>
                                    <button class="btn btn-primary" id="editTask" onclick="formGetTask(${data.id});">Редактировать</button>
                                    <button class="btn btn-danger delete-link" onclick="formDelete(${data.id});">Удалить</button>
                                </td>
                            </tr>`
                $('#tasks_table').append(task);
                $('#taskForm').trigger("reset");
                editTaskModal.destroy();
            },
            error: function (data) {
                if (data.responseJSON.errors.title)
                    $('input[name = "title"]').addClass('border-danger');
                if (data.responseJSON.errors.employee)
                    $('select[name = "employee"]').addClass('border-danger');
                if (data.responseJSON.errors.status)
                    $('select[name = "status"]').addClass('border-danger');
                console.log('Error:', data.responseJSON.errors);
            }
        });
    };

    function formDelete(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:   'DELETE',
            url:    `tasks/${id}`,
            
            success: function () {
                $(`#task_${id}`).remove();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    };

</script>
@endsection