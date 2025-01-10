<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="p-4"> 
    <div class="container">
        
        <h1 class="mb-4 text-center title">Tasks manager</h1>

        <div class="container container-btns d-flex gap-3 p-0">

            {{-- <!-- BUTTONS --> --}}
            <div class="mb-4 ">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">Aggiungi Task</button>
            </div>
           {{-- BTN FILTRED TASKS CLOSED --}}
            <form action="{{ route('tasks.index') }}" method="GET" class="mb-4">
                <input type="hidden" name="showClosed" value="{{ $showClosed ? 0 : 1 }}">
                <button type="submit" class="btn btn-secondary">
                    {{ $showClosed ? 'Nascondi Tasks Chiuse' : 'Mostra Tasks Chiuse' }}
                </button>
            </form>
        </div>


        {{-- TABLE --}}
        <table class="table">
            <thead> 
                <tr>
                    <th>
                        <a class="active text-decoration-none" 
                           href="{{ route('tasks.index', ['sortBy' => 'id', 'sortOrder' => $sortOrder === 'asc' ? 'desc' : 'asc', 'showClosed' => $showClosed]) }}">
                            ID
                        </a>
                    </th>
                    
                    <th>
                        <a class="active text-decoration-none" href="{{ route('tasks.index', ['sortBy' => 'title', 'sortOrder' => $sortOrder === 'asc' ? 'desc' : 'asc', 'showClosed' => $showClosed]) }}">
                            Titolo
                        </a>
                    </th>
                    <th>
                        <a class="active text-decoration-none" href="{{ route('tasks.index', ['sortBy' => 'description', 'sortOrder' => $sortOrder === 'asc' ? 'desc' : 'asc', 'showClosed' => $showClosed]) }}">
                            Descrizione
                        </a>
                    </th>
                    <th>
                        <a class="active text-decoration-none" href="{{ route('tasks.index', ['sortBy' => 'due_date', 'sortOrder' => $sortOrder === 'asc' ? 'desc' : 'asc', 'showClosed' => $showClosed]) }}">
                            Data di Scadenza
                        </a>
                    </th>
                    <th>
                        <a class="active text-decoration-none" href="{{ route('tasks.index', ['sortBy' => 'is_closed', 'sortOrder' => $sortOrder === 'asc' ? 'desc' : 'asc', 'showClosed' => $showClosed]) }}">
                            Stato
                        </a>
                    </th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->due_date }}</td>
                        <td>{{ $task->is_closed ? 'Chiusa' : 'Aperta' }}</td>
                        <td>
                            @if (!$task->is_closed)
                            <form action="{{ route('tasks.complete', $task) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm">Completa Task</button>
                            </form>
                        @endif
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}">Modifica</button>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $task->id }}">
                                    Elimina
                                </button>
                                
                            </form>
                        </td>
                    </tr>

                    {{-- UPDATE MODAL --}}
                    <div class="modal fade" id="editTaskModal{{ $task->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('tasks.update', $task) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Modifica Task</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{-- Titolo --}}
                                        <label for="status" class="form-label">Titolo Task</label>
                                        <input type="text" name="title" class="form-control mb-3" value="{{ $task->title }}" required>
                                        {{-- Descrizione Task --}}
                                        <label for="status" class="form-label">Descrizione Task</label>
                                        <textarea name="description" class="form-control mb-3" required>{{ $task->description }}</textarea>
                                        {{-- Data di scadenza --}}
                                        <label for="status" class="form-label">Data di scadenza</label>
                                        <input type="date" name="due_date" class="form-control mb-3" value="{{ $task->due_date }}">
                                        <!-- Stato -->
                                        <label for="status" class="form-label">Stato Task</label>
                                        <select name="is_closed" class="form-control mb-3" required>
                                            <option value="0" {{ $task->is_closed == 0 ? 'selected' : '' }}>Non ancora completata</option>
                                            <option value="1" {{ $task->is_closed == 1 ? 'selected' : '' }}>Completata</option>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                        <button type="submit" class="btn btn-primary">Salva</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- DELETE MODAL --}}
                    <div class="modal fade" id="deleteModal{{ $task->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $task->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $task->id }}">Conferma eliminazione</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Sei sicuro di voler eliminare questa task, dal titolo "{{ $task->title }}"? 
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Conferma Eliminazione</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ADD TASK MODAL --}}
    <div class="modal fade" id="addTaskModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Aggiungi Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="status" class="form-label">Titolo Task</label>
                        <input type="text" name="title" class="form-control mb-3" placeholder="Titolo" required>
                        <label for="status" class="form-label">Descrizione Task</label>
                        <textarea name="description" class="form-control mb-3" placeholder="Descrizione" required></textarea>
                        <label for="status" class="form-label">Data di scadenza</label>
                        <input type="date" name="due_date" class="form-control mb-3">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                        <button type="submit" class="btn btn-primary">Salva</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
