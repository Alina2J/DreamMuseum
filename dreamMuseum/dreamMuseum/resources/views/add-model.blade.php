@extends('layout')

@section('title', 'Добавление модели')

@section('page-content')
    <section>
        <div class="container-fluid container-content">
            <h2 class="heading-secondary">Добавление публикации</h2>
            <form action="{{route('model.store')}}" method="post" style="display: flex; flex-direction: column;" id="file-upload" class="row g-3 needs-validation" enctype="multipart/form-data">
                @csrf
                <div class="col-md-4">
                    <label for="title" class="form-label">Название</label>
                    <input value="{{old('title')}}" type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" autofocus required>
                    @error('title')
                    <div style="width: 500px" class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="description" class="form-label">Описание</label>
                    <textarea name="description" type="text" rows="5" class="form-control @error('description') is-invalid @enderror" style="width: 440px;" id="description" required>{{old('description')}}</textarea>
                    @error('description')
                    <div style="width: 500px" class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-md-4 validate-me">
                    <label for="image" class="form-label">Изображение</label>
                    <input accept=".jpeg, .png"  name="image" type="file" style="width: 440px;" class="form-control @error('image') is-invalid @enderror" id="image" required>
                    @error('image')
                    <div style="width: 500px" class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="file" class="form-label">Файл модели</label>
                    <input accept=".gltf, .fbx, .obj, .json" name="file" type="file" style="width: 440px;" class="form-control @error('file') is-invalid @enderror" id="file" required>
                    @error('file')
                    <div style="width: 500px" class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="file" class="form-label">Файл модели дополнительно</label>
                    <input accept=".bin" name="files" type="file" style="width: 440px;" class="form-control @error('files') is-invalid @enderror" id="file" required>
                    @error('files')
                    <div style="width: 500px" class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="textures" class="form-label">Текстуры(Вы можете выбрать несколько файлов)</label>
                    <input accept=".jpeg, .png" name="textures[]" type="file" style="width: 440px;" class="form-control @error('files') is-invalid @enderror" id="textures" multiple required>
                    @error('textures')
                    <div style="width: 500px" class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="file_type" class="form-label">Тип модели</label>
                    <select name="file_type" id="file_type" style="width: 430px;" class="form-select @error('file_type') is-invalid @enderror" required>
                        <option selected disabled value="">Выберите...</option>
                        <option value="fbx">fbx</option>
                        <option value="obj">obj</option>
                        <option value="gltf">gltf</option>
                    </select>
                    @error('file_type')
                    <div style="width: 500px" class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="category" class="form-label">Категория</label>
                    <select name="category" style="width: 430px;" class="form-select @error('category') is-invalid @enderror" id="category" required>
                        <option selected disabled value="">Выберите...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                    @error('category')
                    <div style="width: 500px" class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-12">
                    <button class="btn-reset glow" type="submit">Опубликовать</button>
                </div>
            </form>
        </div>
    </section>
@endsection

