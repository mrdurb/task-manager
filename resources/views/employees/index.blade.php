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
            <tr id="employee_{{ $employee->id }}">
                <td>{{ $employee->id }}</td>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->position }}</td>
                <td>
                    <button class="btn btn-primary" id="editEmployee" onclick="window.location.replace('http://127.0.0.1:8000/employees/{{$employee->id}}/edit')">Редактировать</button>
                    <button class="btn btn-danger delete-link" onclick="formDelete('{{ $employee->id }}');">Удалить</button>
                </td>
            </tr>
            @empty
            
            @endforelse
        </tbody>
    </table>
</div>
<button class="btn btn-success float-right mb-3" id="addEmployee" name="btn-add">Добавить</button>
</div>
<script>

    var addEmployeeModal = new jBox('Modal', {
        attach: '#addEmployee',
        title: '<h4>Добавить исполнителя</h4>',
        content: `  <form id="employeeForm" class="addForm">
                        <div class="input-group input-group-lg mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Имя</span>
                            </div>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
                        </div>
                        <div class="input-group input-group-lg mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Должность</span>
                            </div>
                            <input type="text" name="position" class="form-control" value="{{ old('position') }}" />
                        </div>
                        <button class="btn btn-danger float-right" onclick="addEmployeeModal.close();" type="button">Отмена</button>
                        <button class="btn btn-success float-right mr-1" type="submit" id="btn-save" onclick="formSave(window.event);">Сохранить</button>
                    </form>`
    });

    var addConfirm = new jBox('Modal', {
        title: '<h4>Исполнитель добавлен!</h4>',
        content: `<button class="btn btn-success float-right mr-1" type="button" onclick="addConfirm.close();">ОК</button>`
    });

    function formSave(e) {  
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        employeeData = {
            name: $('input[name = "name"]').val(),
            position: $('input[name = "position"]').val(),
        };
        $.ajax({
            type:       'POST',
            url:        'employees',
            data:       employeeData,
            dataType:   'json',

            success: function (data) {  
                employee = `<tr id="employee_${data.id}">
                                <td>${data.id}</td>
                                <td>${data.name}</td>
                                <td>${data.position}</td>
                                <td>
                                    <button class="btn btn-primary" id="editEmployee" onclick="window.location.replace('http://127.0.0.1:8000/employees/${data.id}/edit')">Редактировать</button>
                                    <button class="btn btn-danger delete-link" onclick="formDelete(${data.id});">Удалить</button>
                                </td>
                            </tr>`
                $('#employees_table').append(employee);
                $('#employeeForm').trigger("reset");
                addEmployeeModal.close();
                addConfirm.open();
            },
            error: function (data) {
                if (data.responseJSON.errors.name)
                    $('input[name = "name"]').addClass('border-danger');
                if (data.responseJSON.errors.position)
                    $('input[name = "position"]').addClass('border-danger');
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
            url:    `employees/${id}`,
            
            success: function () {
                $(`#employee_${id}`).remove();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    };

</script>
@endsection