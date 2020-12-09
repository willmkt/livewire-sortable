<div>
    <div class="card">
        <div class="card-body">

            @if (session()->has('message'))
                <div class="alert alert-success" style="margin-top:30px;">x
                {{ session('message') }}
                </div>
            @endif
    
            <ul class="row">
                <div class="col-md-12">
                    <form wire:submit.prevent="create">

                        @if ($update == true)
                        <div class="form-group">
                            <label class="required" for="name">Name</label>
                            <input wire:model="sector_name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                        </div>
                        @else
                            @if ($parent_name)
                                <H4><b>Parent name: {{ $parent_name }}</b></H4>
                            @endif
                
                            <div class="form-group">
                                @if ($parent_name)
                                    <label for="name">Child name</label>
                                @else
                                    <label class="required" for="name">Name</label>
                                @endif
                        
                                <input wire:model="sector_name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                            </div>
                        @endif 
            
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>            
        
                </div>
                <div class="mt-5 col-md-12">

                        <ul wire:ignore wire:sortable="updateParentOrder" wire:sortable-group="updateSectorOrder" class="todo-list crud-menu">
                            @forelse ($this->sectors as $index => $sector)
                                @if ($sector->children->isEmpty())
                                <div wire:key="sector-{{ $sector->id }}" wire:sortable.item="{{ $sector->id }}">
                                    <li class="d-flex crud-item">
                                        <span wire:sortable.handle class="handle align-self-center">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </span> 
                                        <span class="text mr-1 align-self-center">
                                            {{ $sector->name }}
                                        </span> 
                            
                                        <div class="btn-group btn-group-sm ml-auto menu-actions align-self-center">
                                            <a href="#" wire:click.prevent="$emit('parentSelected',{{$sector->id}})" class="btn btn-success btn-sm text-white" data-toggle="modal" data-target="#sectorModal">Add child</i></a>
                                            <a href="#" wire:click.prevent="$emit('edit',{{$sector->id}})" class="btn btn-primary btn-sm text-white" data-toggle="modal" data-target="#sectorModal">Edit</i></a>
                                            <a href="#" wire:click.prevent="delete({{ $sector->id }})" class="btn btn-danger btn-sm text-white">Delete</a>
                                        </div>
                                    </li>
                                </div>    
                                @else                             
                                <div wire:key="sector-{{ $sector->id }}" wire:sortable.item="{{ $sector->id }}"   x-data="{ open: false }">
                                    <li class="d-flex crud-item">                                        
                                        <span wire:sortable.handle class="handle align-self-center">
                                            <i :class="open ? 'fa-minus-square' : 'fa-plus-square'" class="text-dark fas"> </i> 
                                        </span> 
                                        <span @click="open = !open" class="text mr-1 align-self-center hand">
                                            {{ $sector->name }}
                                        </span> 
                                        <div class="btn-group btn-group-sm ml-auto menu-actions align-self-center">
                                            <a href="#" wire:click.prevent="$emit('parentSelected',{{$sector->id}})" class="btn btn-success btn-sm text-white" data-toggle="modal" data-target="#sectorModal">Add child</i></a>
                                            <a href="#" wire:click.prevent="$emit('edit',{{$sector->id}})" class="btn btn-primary btn-sm text-white" data-toggle="modal" data-target="#sectorModal">Edit</i></a>
                                            <a href="#" wire:click.prevent="delete({{ $sector->id }})" class="btn btn-danger btn-sm text-white">Delete</a>
                                        </div>                                          
                                    </li>                                                                                        
                                    <ul x-show.transition.in.duration.800ms="open" wire:sortable-group.item-group="{{ $sector->id }}" class="todo-list crud-menu child-menu">
                                        @foreach ($sector->children as $parent)
                                            @include('livewire.sector.sectorParent', ['parent' => $parent])
                                        @endforeach
                                    </ul>
                                </div>{{-- accordion --}}
                                @endif
                                @empty
                                <h4 class="pl-3 pt-1">Nenhum setor cadastrado</h4>
        
                            @endforelse
                        </ul>    
                </div>{{-- col4 --}}
            </ul>
            
        </div> <!-- end card-body-->
    </div><!-- card -->   

</div>
@section('scripts')

@endsection
