<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-x1 text-gray-800 leading-tight">Create Article</h2>
            <a href ="{{route('articles.index')}}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="post" action="{{route('articles.store')}}">
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Title</label>
                            <div class="my-3">
                                <input placeholder="Enter Title" name="title" value="{{old('title')}}" type="text" class="border-grey-300 shadow-sm w-1/2 rounded-lg">
                                @error('title')
                                <p class="text-red-400">{{$message}}</p>
                                @enderror
                            </div>

                            <label for="" class="text-lg font-medium">Content</label>
                            <div class="my-3">
                            <textarea name="text" id="text" rows="10" class="border-grey-300 shadow-sm w-1/2 rounded-lg" cols="30">{{old('text')}}</textarea>   
                            </div>

                            <label for="" class="text-lg font-medium">Author</label>
                            <div class="my-3">
                                <input placeholder="Enter Author" name="author" value="{{old('author')}}" type="text" class="border-grey-300 shadow-sm w-1/2 rounded-lg">
                                @error('author')
                                <p class="text-red-400">{{$message}}</p>
                                @enderror
                            </div>

                            <button class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>