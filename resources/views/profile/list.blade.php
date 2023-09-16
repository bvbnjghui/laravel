<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            用戶管理
        </h2>
    </x-slot>

    <div class="py-12 px-6">
        <table class="w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <thead>
                <tr>
                    <td class="p-2">姓名</td>
                    <td class="p-2">email</td>
                    <td class="p-2">身分</td>
                    <td class="p-2">操作</td>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="p-2">{{$user->name}}</td>
                    <td class="p-2">{{$user->email}}</td>
                    <td class="p-2">{{$user->role}}</td>
                    <td class="p-2"><a href="{{env('APP_URL')}}/users/{{$user->id}}">編輯</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
