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
                    <button class="btn btn-primary" id="editTask" onclick="window.location.replace('http://127.0.0.1:8000/tasks/{{$task->id}}/edit')">Редактировать</button>
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
                                <option selected value>Выберите сотрудника</option>
                                @forelse($employees as $employee)
                                    <option value="{{ $employee->name }}">{{ $employee->name }}</option>
                                @empty
                                    <option selected value>Никого нет</option>
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

    function formSave(e) {  
        if ($('select[name = "employee"]').val() == "") {
            $('select[name = "employee"]').addClass('border-danger');
        }
        else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            e.preventDefault();
            taskData = {
                title: $('input[name = "title"]').val(),
                employee: $('select[name = "employee"]').val(),
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
                                        <button class="btn btn-primary" id="editTask" onclick="window.location.replace('http://127.0.0.1:8000/tasks/${data.id}/edit')">Редактировать</button>
                                        <button class="btn btn-danger delete-link" onclick="formDelete(${data.id});">Удалить</button>
                                    </td>
                                </tr>`
                    $('#tasks_table').append(task);
                    $('#taskForm').trigger("reset");
                    addTaskModal.close();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        };
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