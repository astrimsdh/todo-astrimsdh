
@extends('template.index')
@section('container')
<div class="d-flex justify-content-center align-items-center full-height">
    <div class="card" style="width: 50rem;">
        <div class="card-header">
            <h5 class="card-title d-flex justify-content-between align-items-center">
                <span class="">To Do List APP</span>
                <form action="/logout" method="post">
                    @csrf
                <div class="btn-group me-2" role="group" aria-label="First group">
                    
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="list" data-status="false">
                        <i class="fa-solid fa-list"></i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="archive" data-status="false">
                        <i class="fa-solid fa-box-archive"></i>
                    </button>
                    
                        <button type="submit" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-power-off"></i>
                        </button>
                    </form>
                    
                  </div>
            </h5>
        </div>
        <div class="card-body">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Cari To Do List" aria-label="Recipient's username" name="search" id="search">
                <button class="input-group-text" id="btn-search">Cari</button>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <div class="row">
                        <div class="col">
                          <input type="date" class="form-control" placeholder="Tanggal Awal" id="start_date" >
                        </div>
                        -
                        <div class="col">
                          <input type="date" class="form-control" placeholder="Tanggal Akhir" aria-label="Last name" id="end_date">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="tanggal" class="form-label">Prioritas</label>
                    <select class="form-select" aria-label="Default select example" id="filter_priority">
                        <option value="">Pilih Prioritas</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                      </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-sm btn-secondary flex-fill mb-1" id="filter">Filter</button>
                </div>
            </div>
            <div class="mt-3">
                <h6 class="card-title">Hi {{ auth()->user()->name }}, List Kerjaan Nih : </h6>
                <ul class="list-group">
                    <!-- Todo Item 1 -->

                    
                  </ul>
            </div>
            
            
        </div>
        <div class="card-footer">
            <form action="javascript:;" id="form-task">
                @csrf
            <div class="input-group">
                
                <input type="text" class="form-control" placeholder="Tambah To Do List Baru" aria-describedby="basic-addon2" name="title" id="title">
                <input type="date" class="form-control" placeholder="" aria-describedby="basic-addon2" name="due_date" id="due_date">
                <select id="priority" class="form-control" name="priority">
                    <option value="">Pilih Prioritas</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
            </form>
                <button class="input-group-text btn btn-primary" id="add_task">Tambah</button>
            </div>
        </div>
    </div>
</div>

@endsection()

@section('script')
<!-- Tambahkan ini setelah Bootstrap JS -->

<script>   

    $(document).ready(function() {
    data();

    $('#list').on("click", function() {
        let searchValue = $('#search').val();
        let filters = {};
        filters.status = 0;
        $.ajax({
            url: "{{ route('todos.fetch') }}",
            type: "GET",
            data: filters,
            success: function(data) {
                renderTodos(data);
            }
        });
    });

    $('#archive').on("click", function() {
        let searchValue = $('#search').val();
        let filters = {};
        filters.status = 1;
        $.ajax({
            url: "{{ route('todos.fetch') }}",
            type: "GET",
            data: filters,
            success: function(data) {
                renderTodos(data);
            }
        });
    });

    function data() {
        reset();
        $.ajax({
            url: "{{ route('todos.fetch') }}",
            type: "GET",
            success: function(data) {
                renderTodos(data);
            }
        });
    }

    // Event listener untuk tombol pencarian
    $("#btn-search").on("click", function() {
        let searchValue = $('#search').val();
        $.ajax({
            url: "{{ route('todos.fetch') }}",
            type: "GET",
            data: {search: searchValue},
            success: function(data) {
                renderTodos(data);
            }
        });  // Kirimkan nilai pencarian ke fungsi data()
    });

    $("#filter").on("click", function() {
        let startDate = $('#start_date').val();
        let endDate = $('#end_date').val();
        let priority = $('#filter_priority').val();

        let filters = {};
        if (startDate) filters.start_date = startDate;
        if (endDate) filters.end_date = endDate;
        if (priority) filters.priority = priority;

        $.ajax({
            url: "{{ route('todos.fetch') }}",
            type: "GET",
            data: filters,
            success: function(data) {
                renderTodos(data);
            }
        }); 
    });

    
    
    function reset() {
        let form = $("form[id='form-task']").serializeArray();
        form.map((a) => {
            $(`#${a.name}`).val("");
        });
    }
    function renderTodos(todos) {
        let todoList = $('.list-group');
        todoList.empty();
        var todoItem = $(this).closest('li');
        todos.forEach(function(todo) {
            let status = "";
            let dueDate = new Date(todo.due_date);
            let today = new Date();

            if (today > dueDate) {
                status = "danger";
            } else {
                status = "success";
            }

            let priorityBadge = '';
            if (todo.priority == 'low') {
                priorityBadge = '<span class="badge text-bg-info">Low</span>';
            } else if (todo.priority == 'medium') {
                priorityBadge = '<span class="badge text-bg-warning">Medium</span>';
            } else if (todo.priority == 'high') {
                priorityBadge = '<span class="badge text-bg-danger">High</span>';
            }

            let htmlDueDate = ''
            if (todo.due_date){
                htmlDueDate = `<br> (<small class="text-${status}">${todo.due_date}</small>)`
            }

            let completed = ''
            if (todo.status) {
                completed = 'text-decoration-line-through'
            }

            todoList.append(`
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="todo-${todo.id}" data-id=${todo.id}>
                        <label class="form-check-label ${completed}" for="todo-${todo.id}">
                            ${todo.title} ${priorityBadge}
                            ${htmlDueDate}
                        </label>
                    </div>
                    <button class="btn-close btn-sm" data-id=${todo.id}></button>
                </li>
            `);
        });
    }

    $("#add_task").on("click", function () {
        let form = $("form[id='form-task']").serialize();
        
        $.ajax({
            data: form,
            url: "/",
            type: "POST",
            dataType: 'json',
            success: function (response) {
                if (response.errors) {
                    displayErrors(response.errors); 
                } else {
                    reset();
                    $.ajax({
                        url: "{{ route('todos.fetch') }}",
                        type: "GET",
                        success: function(data) {
                            renderTodos(data);
                        }
                    });

                    Swal.fire("Success!", response.success, "success");
                }
            }
        });
    });

    $(document).on('click', '.btn-close', function() {
        let todoId = $(this).data('id');
        let todoItem = $(this).closest('li');

        $.ajax({
            url: '/todos/' + todoId,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}' 
            },
            success: function(response) {
                if (response.success) {
                    todoItem.remove();

                    Swal.fire("Success!", response.success, "success");
                } else {
                    Swal.fire("Error!", response.error, "error");
                }
            }
        });
    });

    $(document).on('change', 'input[type="checkbox"]', function() {
        var isChecked = $(this).is(':checked');
        var todoId = $(this).data('id');
        var todoItem = $(this).closest('li');

        $.ajax({
            url: '/todos/' + todoId + '/toggle-complete',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                status: isChecked
            },
            success: function(response) {
                if (response.success) {
                    // Toggle the line-through class based on the new status
                    if (response.status) {
                        todoItem.find('.form-check-label').addClass('text-decoration-line-through');
                    } else {
                        todoItem.find('.form-check-label').removeClass('text-decoration-line-through');
                    }
                    Swal.fire("Success!", response.success, "success");
                } else {
                    Swal.fire("Error!", response.error, "error");
                }
            }
        });
    });
});


</script> 
@endsection