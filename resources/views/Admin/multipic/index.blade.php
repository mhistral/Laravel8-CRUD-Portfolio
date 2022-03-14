<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Hi.. <b>{{Auth::user()->name}}</b>
            Multi Picture
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">

                <div class="col-md-8">
                    <div class="card-group">
                        @foreach ($images as $multi)
                            <div class="mt-5 col-md-4">
                                <div class="card">
                                    <img src="{{ asset($multi->image) }}" alt="">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Add Multi Picture</div>
                            <div class="card-body">
                                <form action="{{ route('store.image') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <input type="file" name="image[]" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" multiple="">
                                        @error('image')
                                        <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary">Add Multi Picture</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
