<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-x1 text-gray-800 leading-tight">Articles</h2>
            @can('create articles')
            <a href="{{route('articles.create')}}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Create</a>
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
                        <th class="px-6 py-3 text-left">Title</th>
                        <th class="px-6 py-3 text-left">Description</th>
                        <th class="px-6 py-3 text-left">Author</th>
                        <th class="px-6 py-3 text-left">Created</th>
                        <th class="px-6 py-3 text-center">Action</th>
                    </tr>
                </thead>
                @forelse ($articles as $article)
                <tbody class="bg-white">
                    <tr class="border-b">
                        <td class="px-6 py-3 text-left">{{ $loop->iteration }}</td>
                        <td class="px-6 py-3 text-left">{{ $article->title }}</td>
                        <td class="px-6 py-3 text-left">{{ $article->text }}</td>
                        <td class="px-6 py-3 text-left">{{ $article->author }}</td>
                        <td class="px-6 py-3 text-left">{{ \Carbon\Carbon::parse($article->created_at)->format('d-M-Y') }}</td>
                        <td class="px-6 py-3 text-center">
                            @can('edit articles')
                            <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="{{ route('articles.edit', $article->id) }}">Edit</a>
                           @endcan
                           @can('delete articles')
                            <a class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded cursor-pointer"
                                onclick="deleteArticle({{ $article->id }})">
                                Delete
                            </a>
                            @endcan

                        </td>
                    </tr>
                </tbody>
                @empty
                <tr>
                    <td colspan="4">No Data</td>
                </tr>
                @endforelse
            </table>
            <div class="my-3">
                {{ $articles->links() }}
            </div>
            </table>
        </div>
    </div>
    <x-slot name="script">
        <script type="text/javascript">
            function deleteArticle(id) {
                var url = "{{ route('articles.destroy') }}";
                if (confirm("Are you sure you want to delete this Article?")) {
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
                                window.location.href = "{{ route('articles.index') }}"; // Redirect on success
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