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
                    <button class="btn btn-primary" id="editEmployee" onclick="window.location.replace('http://127.0.0.1:8000/employees/{{$employee->id}}/edit')">Редактировать</button>
                    <button class="btn btn-danger" onclick="window.location.replace('http://127.0.0.1:8000/employees/{{$employee->id}}/delete')">Удалить</button>
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
<button class="btn btn-success float-right mb-3" id="addEmployee">Добавить</button>
</div>
<script>

    var addEmployeeModal = new jBox('Modal', {
        attach: '#addEmployee',
        title: '<h4>Добавить исполнителя</h4>',
        content: `  <form id="employeeForm" method="POST" action="/employees" class="addForm">
                        {{ csrf_field() }}
                        <div class="input-group input-group-lg mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Имя</span>
                            </div>
                            <input type="text" name="name" class="form-control" required />
                        </div>
                        <div class="input-group input-group-lg mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Должность</span>
                            </div>
                            <input type="text" name="position" class="form-control" required />
                        </div>
                        <button class="btn btn-danger float-right" onclick="addEmployeeModal.close();">Отмена</button>
                        <button class="btn btn-success float-right mr-1" type="submit">Сохранить</button>
                    </form>`
    });

    // var editEmployeeModal = new jBox('Modal', {
    //     attach: '#editEmployee',
    //     title: '<h4>Редактировать исполнителя</h4>',
    //     content: `  <form id="employeeForm" method="POST" action="/employees" class="editForm">
    //                     {{ csrf_field() }}
    //                     @method('PUT')
    //                     <div class="input-group input-group-lg mb-4">
    //                         <div class="input-group-prepend">
    //                             <span class="input-group-text">Имя</span>
    //                         </div>
    //                         <input type="text" class="form-control" required />
    //                     </div>
    //                     <div class="input-group input-group-lg mb-4">
    //                         <div class="input-group-prepend">
    //                             <span class="input-group-text">Должность</span>
    //                         </div>
    //                         <input type="text" class="form-control" required />
    //                     </div>
    //                     <button class="btn btn-danger float-right" onclick="editEmployeeModal.close();">Отмена</button>
    //                     <button class="btn btn-success float-right mr-1" type="submit">Сохранить</button>
    //                 </form>`
    // });
</script>
@endsection