<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-x1 text-gray-800 leading-tight">Create User</h2>
            <a href="{{route('users.index')}}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="post" action="{{route('users.store')}}">
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                <input placeholder="Enter Name" name="name" value="{{old('name')}}" type="text" class="border-grey-300 shadow-sm w-1/2 rounded-lg">
                                @error('name')
                                <p class="text-red-400">{{$message}}</p>
                                @enderror
                            </div>
                            <label for="" class="text-lg font-medium">Email</label>
                            <div class="my-3">
                                <input placeholder="Enter Email" name="email" value="{{old('email')}}" type="text" class="border-grey-300 shadow-sm w-1/2 rounded-lg">
                                @error('email')
                                <p class="text-red-400">{{$message}}</p>
                                @enderror
                            </div>
                            <label for="" class="text-lg font-medium">Password</label>
                            <div class="my-3">
                                <input placeholder="Enter Password" name="password" value="{{old('password')}}" type="password" class="border-grey-300 shadow-sm w-1/2 rounded-lg">
                                @error('password')
                                <p class="text-red-400">{{$message}}</p>
                                @enderror
                            </div>

                            <label for="" class="text-lg font-medium">Confirm Password</label>
                            <div class="my-3">
                                <input placeholder="Enter Confirm Password" name="confirm_password" value="{{old('confirm_password')}}" type="password" class="border-grey-300 shadow-sm w-1/2 rounded-lg">
                                @error('confirm_password')
                                <p class="text-red-400">{{$message}}</p>
                                @enderror
                            </div>
                           
                            <div class="grid grid-cols-4 mb-3">
                                @forelse ($roles as $role)
                                <div class="mt-3">
                                    <input type="checkbox" id="role{{$role->id}}" class="rounded" name="role[]" value="{{$role->name}}">
                                    <label for="role_{{$role->id}}">{{$role->name}}</label>
                                </div>
                                @empty
                                <div class="mt-3">No Data</div>
                                @endforelse
                            </div>
                            
                            <button class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>