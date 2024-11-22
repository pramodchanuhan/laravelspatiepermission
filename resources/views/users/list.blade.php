<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-x1 text-gray-800 leading-tight">Users</h2>
            @can('create users')
            <a href="{{route('users.create')}}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Create</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>
            <table class="w-full ">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th class="px-6 py-3 text-left">#</th>
                        <th class="px-6 py-3 text-left">Name</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Roles</th>
                        <th class="px-6 py-3 text-left">Created</th>
                        <th class="px-6 py-3 text-center">Action</th>
                    </tr>
                </thead>
                @forelse ($users as $user)
                <tbody class="bg-white">
                    <tr class="border-b">
                        <td class="px-6 py-3 text-left">{{ $loop->iteration }}</td>
                        <td class="px-6 py-3 text-left">{{ $user->name }}</td>
                        <td class="px-6 py-3 text-left">{{ $user->email }}</td>
                        <td class="px-6 py-3 text-left">{{ $user->roles->pluck('name')->implode(', ') }}</td>
                        <td class="px-6 py-3 text-left">{{ \Carbon\Carbon::parse($user->created_at)->format('d-M-Y') }}</td>
                        <td class="px-6 py-3 text-center">
                            @can('edit users')
                            <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="{{ route('users.edit', $user->id) }}">Edit</a>
                            @endcan
                            @can('delete users')
                            <a class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded cursor-pointer"
                                onclick="deleteUser({{ $user->id }})">
                                Delete
                            </a>
                            @endcan
                        </td>
                    </tr>
                </tbody>
                @empty
                <tr>
                    <td colspan="4">No User Found</td>
                </tr>
                @endforelse
            </table>
            <div class="my-3">
                {{ $users->links() }}
            </div>
            </table>
        </div>
    </div>
    <x-slot name="script">
        <script type="text/javascript">
            function deleteUser(id) {
                var url = "{{ route('users.destroy') }}";
                if (confirm("Are you sure you want to delete this user?")) {
                    $.ajax({
                        type: 'delete', // Use the correct HTTP method for deleting
                        url: url,
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'), // Fetch CSRF token from meta tag
                            id: id
                        },
                        dataType: 'json',
                        success: function(result) {
                            if (result.status) {
                                window.location.href = "{{ route('users.index') }}"; // Redirect on success
                            }
                        },
                        error: function(xhr) {
                            alert('An error occurred. Please try again.'); // Handle any AJAX errors
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>