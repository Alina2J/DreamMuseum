@extends('layout')

@section('title', 'Пост')

@section('scripts')
    @if($post->model_type === 'gltf')
        <script type="module">
            import { GLTFLoader } from 'https://cdn.skypack.dev/three@0.136.0/examples/jsm/loaders/GLTFLoader.js';
            import { OrbitControls } from 'https://cdn.skypack.dev/three@0.136.0/examples/jsm/controls/OrbitControls.js';

            const renderer = new THREE.WebGLRenderer({alpha:true, antialias:true});
            renderer.setClearColor(0xffffff, 1);
            const width = window.innerWidth;
            const height = window.innerHeight;
            if(width <= 1920 || height <=1280 || width > 1024 || height > 860) {
                renderer.setSize(1390, 700);
            } else if (width <= 1024 || height <=860) {
                renderer.setSize(90, 90);
            }
            renderer.shadowMap.enabled = true;
            renderer.shadowMap.type = THREE.PCFShadowMap;
            document.body.appendChild(renderer.domElement);

            const scene = new THREE.Scene();

            const camera = new THREE.PerspectiveCamera(7, window.innerWidth / window.innerHeight, 0.1, 1000);

            renderer.domElement.setAttribute("id", "Model3DObj");
            document.body.insertBefore(renderer.domElement, document.body.firstChild);

            var ambientLight = new THREE.AmbientLight( 0x606060 );
            scene.add( ambientLight );

            const loader = new GLTFLoader();
            const fileName = {!! json_encode('/storage/'.$model) !!};
            let model;

            const controls = new OrbitControls(camera, renderer.domElement);
            controls.screenSpacePanning = true;

            var light;
            const color = 0xFFFFFF;
            const intensity = 10;
            light = new THREE.PointLight(color, intensity);
            light.castShadow = true;
            light.shadow.radius = 5;
            light.shadow.mapSize.x = 1024;
            light.shadow.mapSize.y = 1024;
            light.position.set(0, 100, 0);
            scene.add(light);


            loader.load(fileName, function (gltf) {
                model = gltf.scene;
                model.traverse(function (node) {
                    if (node.isMesh) {
                        node.castShadow = true;
                    }
                });

                scene.add(model);
                addLight();
                adjustModelAndCamera();
                scene.add(camera);
                renderer.render(scene, camera);
            }, undefined, function (e) {
                console.error(e);
            });

            function addLight() {
                const light = new THREE.DirectionalLight(0xffffff, 1);
                light.position.set(0.5, 100, 0.866);
                light.castShadow = true;
                camera.add(light);
            }

            function adjustModelAndCamera() {
                const box = new THREE.Box3().setFromObject(model);
                const size = box.getSize(new THREE.Vector3()).length();
                const center = box.getCenter(new THREE.Vector3());

                model.position.x += (model.position.x - center.x);
                model.position.y += (model.position.y - center.y);
                model.position.z += (model.position.z - center.z);

                camera.near = size / 100;
                camera.far = size * 100;
                camera.updateProjectionMatrix();

                camera.position.copy(center);
                camera.position.x += size / 0.2;
                camera.position.y += size / 2;
                camera.position.z += size / 100;
                camera.lookAt(center);
            }

            renderer.render(scene, camera);

            function animate() {
                requestAnimationFrame(animate);
                controls.update();
                renderer.render(scene, camera);
            }
            animate();

        </script>
    @elseif($post->model_type === 'fbx')
        <script type="module">
            import { OrbitControls } from 'https://cdn.skypack.dev/three@0.136.0/examples/jsm/controls/OrbitControls.js';

            // создаем сцену
            var scene = new THREE.Scene();

            // создаем камеру
            var camera = new THREE.PerspectiveCamera( 10, window.innerWidth / window.innerHeight, 0.1, 1000 );
            camera.position.z = 5;

            // создаем рендерер
            var renderer = new THREE.WebGLRenderer({alpha:true, antialias:true});
            renderer.setClearColor(0xffffff, 1);
            renderer.setSize( 1390, 700 );
            document.body.appendChild( renderer.domElement );

            renderer.domElement.setAttribute("id", "Model3DObj");
            document.body.insertBefore(renderer.domElement, document.body.firstChild);

            // добавляем свет
            var ambientLight = new THREE.AmbientLight( 0x606060 );
            scene.add( ambientLight );

            var light;
            const color = 0xFFFFFF;
            const intensity = 2;
            light = new THREE.PointLight(color, intensity);
            light.castShadow = true;
            light.shadow.radius = 5;
            light.shadow.mapSize.x = 1024;
            light.shadow.mapSize.y = 1024;
            light.position.set(0, 10, 0);
            scene.add(light);

            var darkMaterial = new THREE.MeshPhongMaterial ({color: 'hsl(269,53%,30%)', emissive: 'hsl(267,38%,46%)',
                shininess: 0});


            // загружаем модель
            var loader = new THREE.FBXLoader();
            loader.load( {!! json_encode('/storage/'.$model) !!}, function ( object ) {

                object.traverse(function(child) {
                    if (child instanceof THREE.Mesh) {
                        child.material = darkMaterial;
                    }});

                const box = new THREE.Box3().setFromObject(object);
                const size = box.getSize(new THREE.Vector3()).length();
                const center = box.getCenter(new THREE.Vector3());

                object.position.x += (object.position.x - center.x);
                object.position.y += (object.position.y - center.y);
                object.position.z += (object.position.z - center.z);

                camera.near = size / 100;
                camera.far = size * 100;
                camera.updateProjectionMatrix();

                camera.position.x += size / 0.2;
                camera.position.y += size / 2;
                camera.position.z += size / 100;
                camera.lookAt(center);

                scene.add( object );
            });

            // создаем контролы для управления камерой
            const controls = new OrbitControls(camera, renderer.domElement);
            controls.screenSpacePanning = true;


            // рендерим сцену каждый кадр
            function animate() {
                requestAnimationFrame( animate );
                renderer.render( scene, camera );
            }
            animate();

        </script>
    @elseif($post->model_type === 'obj')
        <script type="module">
            import { OrbitControls } from 'https://cdn.skypack.dev/three@0.136.0/examples/jsm/controls/OrbitControls.js';

            // создаем сцену
            var scene = new THREE.Scene();

            // создаем камеру
            var camera = new THREE.PerspectiveCamera( 7, window.innerWidth / window.innerHeight, 0.1, 1000 );
            camera.position.z = 5;

            // создаем рендерер
            var renderer = new THREE.WebGLRenderer({alpha:true, antialias:true});
            renderer.setClearColor(0xffffff, 1);
            renderer.setSize( 1390, 700 );
            document.body.appendChild( renderer.domElement );

            renderer.domElement.setAttribute("id", "Model3DObj");
            document.body.insertBefore(renderer.domElement, document.body.firstChild);

            // добавляем свет
            var ambientLight = new THREE.AmbientLight( 0x606060 );
            scene.add( ambientLight );

            var light;
            const color = 0xFFFFFF;
            const intensity = 2;
            light = new THREE.PointLight(color, intensity);
            light.castShadow = true;
            light.shadow.radius = 5;
            light.shadow.mapSize.x = 1024;
            light.shadow.mapSize.y = 1024;
            light.position.set(0, 10, 0);
            scene.add(light);

            var darkMaterial = new THREE.MeshPhongMaterial ({color: 'hsl(269,53%,30%)', emissive: 'hsl(267,38%,46%)',
                shininess: 0});

            // загружаем модель
            var loader = new THREE.OBJLoader();
            loader.load( {!! json_encode('/storage/'.$model) !!}, function ( object ) {
                object.traverse(function(child) {
                    if (child instanceof THREE.Mesh) {
                        child.material = darkMaterial;
                    }});
                const box = new THREE.Box3().setFromObject(object);
                const size = box.getSize(new THREE.Vector3()).length();
                const center = box.getCenter(new THREE.Vector3());

                object.position.x += (object.position.x - center.x);
                object.position.y += (object.position.y - center.y);
                object.position.z += (object.position.z - center.z);

                camera.near = size / 100;
                camera.far = size * 100;
                camera.updateProjectionMatrix();

                camera.position.x += size / 0.2;
                camera.position.y += size / 2;
                camera.position.z += size / 100;
                camera.lookAt(center);

                scene.add( object );
            });

            // создаем контролы для управления камерой
            const controls = new OrbitControls(camera, renderer.domElement);
            controls.screenSpacePanning = true;


            // рендерим сцену каждый кадр
            function animate() {
                requestAnimationFrame( animate );
                renderer.render( scene, camera );
            }
            animate();

        </script>
    @endif
@endsection

@section('page-content')
    <section>
        <div class="container-fluid container-content">
            <div class="author">
                <img src="/storage/{{$post->user->photo_url}}" alt="author">
                <div class="author-post-info">
                    @if(Auth::user())
                        @if(Auth::user()->id === $post->user->id)
                            <a href="{{route('profile')}}"><h5 class="author-name">{{$post->user->login}}</h5></a>
                        @else
                            <a href="{{route('profile-user', ['id' => $post->user->id])}}"><h5 class="author-name">{{$post->user->login}}</h5></a>
                        @endif
                    @else
                        <a href="{{route('profile-user', ['id' => $post->user->id])}}"><h5 class="author-name">{{$post->user->login}}</h5></a>
                    @endif
                    <time>{{ $date->format('d.m.Y') }}</time>
                </div>
            </div>
            <div class="model">
                <canvas class="scene" id="bubble"></canvas>
            </div>
            <div class="info-model">
                <div class="name-category">
                    <h3>{{$post->title}}</h3>
                    <a href="">{{$post->category->title}}</a>
                </div>
                <form action="{{route('favourites', $post->id)}}" method="post">
                    @csrf
                    @if(Auth::user())
                        @if(Auth::user()->isAdmin())
                        @else
                            <button type="submit" class="btn btn-outline-danger {{ Auth::user()->like->contains($post->id) ? 'btn-danger text-white' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-heart-eyes" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M11.315 10.014a.5.5 0 0 1 .548.736A4.498 4.498 0 0 1 7.965 13a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .548-.736h.005l.017.005.067.015.252.055c.215.046.515.108.857.169.693.124 1.522.242 2.152.242.63 0 1.46-.118 2.152-.242a26.58 26.58 0 0 0 1.109-.224l.067-.015.017-.004.005-.002zM4.756 4.566c.763-1.424 4.02-.12.952 3.434-4.496-1.596-2.35-4.298-.952-3.434zm6.488 0c1.398-.864 3.544 1.838-.952 3.434-3.067-3.554.19-4.858.952-3.434z"/>
                                </svg>
                                {{ $likes }}
                            </button>
                        @endif
                    @endif
                </form>
            </div>
            <p>Формат:  <b>{{$post->model_type}}</b></p>
            <div class="desc-model">
                <p style="display: flex;">
                    {{$post->description}}
                </p>
                    @if(Auth::user())
                        @if(Auth::user()->id === $post->user->id || Auth::user()->isAdmin())
                                <div style="display: flex; flex-direction: column; justify-content: center; align-items: flex-end; gap: 20px">
                                    <form action="{{ route('delete-post', $post->id )}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-reset glow">Удалить пост</button>
                                    </form>
                                    @if(Auth::user()->isAdmin())
                                    @else
                                        <a href="{{route('post.edit', $post->id)}}" class="btn-reset glow">Редактировать пост</a>
                                    @endif
                            </div>
                        @else
                        <a href="{{route('load-model', $post->id)}}" type="button" class="btn-reset glow">Скачать модель</a>
                        @endif
                    @else
                        <a href="{{route('load-model', $post->id)}}" type="button" class="btn-reset glow">Скачать модель</a>
                   @endif
            </div>
            <div class="comments">
                <h3 style="margin-bottom: 20px;">Комментарии  ({{$comments->count()}})</h3>
                @if(Auth::user())
                    @if(Auth::user()->isAdmin())
                    @else
                    <form action="{{route('comments', $post->id)}}" method="post">
                        @csrf
                        <div class="comment-write">
                            <img src="/storage/{{Auth::user()->photo_url}}" alt="user">
                            <div class="col-3 input-effect">
                                <input name="comment" class="effect-16" type="text" placeholder="">
                                <label>Введите комментарий...</label>
                                <span class="focus-border"></span>
                                @error('comment')
                                <div style="width: 500px" class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </form>
                    @endif
                @endif
                @if($comments->isNotEmpty())
                    @foreach($comments->reverse() as $comment)
                        <x-comment :post="$post" :comment="$comment"></x-comment>
                    @endforeach
                @else
                    <h3>Здесь ещё нет комментариев :(</h3>
                    <p>Оставьте свой комментарий</p>
                @endif

            </div>
        </div>
    </section>
@endsection
