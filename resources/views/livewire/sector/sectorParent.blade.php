@if (!empty($parent->parent->isEmpty()))
    <div wire:key="parent-{{ $parent->id }}"  wire:sortable-group.item="{{ $parent->id }}" >
        <li class="d-flex crud-item" >
            <span  wire:sortable-group.handle class="handle align-self-center">
                <i class="fas fa-ellipsis-v"></i>
            </span> 
            <span class="text mr-1 align-self-center">
                {{ $parent->name }}
            </span> 
            <div class="btn-group btn-group-sm ml-auto menu-actions align-self-center">
                <a href="#" wire:click.prevent="$emit('parentSelected',{{$parent->id}})" class="btn btn-secondary btn-sm text-white" data-toggle="modal" data-target="#sectorModal"><i class="fas fa-plus"></i></a>
                <a href="#" wire:click.prevent="$emit('edit',{{$parent->id}})" class="btn btn-secondary btn-sm text-white" data-toggle="modal" data-target="#sectorModal"><i class="far fa-edit"></i></a>
                <a href="#" wire:click="delete({{ $parent->id }})" class="btn btn-secondary btn-sm text-white"><i class="far fa-trash-alt"></i></a>
            </div>
        </li>
    </div>        
@else
    <div wire:key="parent-{{ $parent->id }}"  x-data="{ open: false }" >
        <li  wire:sortable-group.item="{{ $parent->id }}" class="d-flex crud-item">
            <span wire:sortable-group.handle class="handle align-self-center">
                <i :class="open ? 'fa-minus-square' : 'fa-plus-square'" class="text-dark fas"> </i> 
            </span> 
            <span @click="open = !open" class="text mr-1 align-self-center hand">
                {{ $parent->name }}
            </span> 
            <div class="btn-group btn-group-sm ml-auto menu-actions align-self-center">
                <a href="#" wire:click.prevent="$emit('parentSelected',{{$parent->id}})" class="btn btn-secondary btn-sm text-white" data-toggle="modal" data-target="#sectorModal"><i class="fas fa-plus"></i></a>
                <a href="#" wire:click.prevent="$emit('edit',{{$parent->id}})" class="btn btn-secondary btn-sm text-white" data-toggle="modal" data-target="#sectorModal"><i class="far fa-edit"></i></a>
                <a href="#" wire:click="delete({{ $parent->id }})" class="btn btn-secondary btn-sm text-white"><i class="far fa-trash-alt"></i></a>
            </div>
        </li>
        <ul x-show.transition.in.duration.800ms="open" wire:sortable-group.item-group="{{ $parent->parent_id }}" class="todo-list crud-menu child-menu">
            @if ($parent->parent)
                @foreach ($parent->parent as $parent)
                    @include('livewire.sector.sectorParent', ['parent' => $parent])
                @endforeach
            @endif
        </ul>
    </div>
@endif

