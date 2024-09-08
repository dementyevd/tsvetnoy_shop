<div>
    <div>
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <h2>Список пользователей</h2>

    <table class="table table-bordered mt-5">
        <thead>
            <tr>
                <th>Имя</th>
                <th>Email</th>
                <th>Роль</th>
                <th width="100px">Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $item)
                <tr>
                    <td>{{$item->name}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{$item->role}}</td>
                    <td>                        
                        <button class="btn btn-danger btn-sm" wire:click="delete({{$item->id}})">Удалить</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
