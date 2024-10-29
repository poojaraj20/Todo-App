@section('title', 'Dashboard')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>



    <div class="container mx-auto mt-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <h2 class="text-lg font-bold">Create New Project</h2>
                    <form action="{{ url('/projects') }}" method="POST" class="mb-4">
                        @csrf
                        <input type="text" name="title" placeholder="Project Title" required class="border rounded p-2">
                        <button type="submit" style="background-color: green; color: white; border-radius: 0.25rem; padding: 0.25rem 0.5rem;">Create Project</button>
                    </form>
            </div>
        </div>
        <br>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2 class="text-lg font-bold" style="margin-left: 1rem;">Projects</h2>
            </div>
        </div>
        <br>

        
        @foreach($projects as $project)
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="border p-4 mb-4 rounded shadow">
                        <h3 class="text-xl">{{ $project->title }}</h3>

                        <!-- Gist Export Button -->
                        <form action="{{ route('export.gist') }}" method="POST" class="mb-4">
                            @csrf
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                            <button type="submit" style="background-color: blue; color: white; border-radius: 0.25rem; padding: 0.25rem 0.5rem;">
                                Export Gist
                            </button>
                        </form>
                        <form action="{{ url('/projects/'.$project->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background-color: red; color: white; border-radius: 0.25rem; padding: 0.25rem 0.5rem;">Delete Project</button>
                        </form>

                        <h4 class="mt-4 font-semibold">Todos</h4>
                        <form action="{{ url('/projects/'.$project->id.'/todos') }}" method="POST" class="mb-2">
                            @csrf
                            <input type="text" name="description" placeholder="Todo Description" required class="border rounded p-2">
                            <button type="submit" style="background-color: green; color: white; border-radius: 0.25rem; padding: 0.25rem 0.5rem;">Add Todo</button>
                        </form>

                        <ul class="list-disc pl-5">
                            @foreach($project->todos as $todo)
                                <li class="flex items-center justify-between mb-2">
                                    <form action="{{ url('/todos/'.$todo->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="text" name="description" value="{{ $todo->description }}" required class="border rounded p-1">
                                        <input type="checkbox" name="status" value="1" {{ $todo->status ? 'checked' : '' }}> 
                                        <span style="background-color: blue; color: white; padding: 6px 5px; border-radius: 3px;">Complete</span>
                                    
                                        <button type="submit" style="background-color: orange; color: white; border-radius: 0.25rem; padding: 0.25rem 0.5rem;">Update</button>
                                    </form>
                                    <form action="{{ url('/todos/'.$todo->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background-color: red; color: white; border-radius: 0.25rem; padding: 0.25rem 0.5rem;">Delete</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <br>
        @endforeach
    </div>
    


    

</x-app-layout>

