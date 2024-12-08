<template>
<div class="min-vh-100 bg-black text-white d-flex flex-column">
    <!-- Заголовок -->
    <header class="py-4 bg-danger shadow-lg">
        <h1 class="text-center fw-bold display-4">Музыкалық плейлист</h1>
    </header>

    <!-- Табуляция -->
    <div class="bg-secondary py-3">
        <div class="d-flex justify-content-center gap-3">
            <button class="btn btn-outline-light" :class="{ 'text-danger border-danger bg-white': activeTab === 'tracks' }" @click="activeTab = 'tracks'">
                Барлық музыка
            </button>
            <button class="btn btn-outline-light" :class="{ 'text-danger border-danger bg-white': activeTab === 'albums' }" @click="activeTab = 'albums'">
                Альбомдар
            </button>
            <button class="btn btn-outline-light" :class="{ 'text-danger border-danger bg-white': activeTab === 'myTracks' }" @click="activeTab = 'myTracks'">
                Менің сақтаған музыкаларым
            </button>
            <button class="btn btn-outline-light" :class="{ 'text-danger border-danger bg-white': activeTab === 'myAlbums' }" @click="activeTab = 'myAlbums'">
                Менің сақтаған альбомдарым
            </button>
            <!-- Поисковый инпут -->
            <div class="d-flex">
                <input type="text" class="form-control" placeholder="Іздеу..." v-model="filter.title" @keyup.enter="search" />  
            </div>
            <Link class="btn btn-danger mr-2" :href="route('main')">
            <i class="fa fa-trash"></i> Фильтрді тазалау
            </Link>
            <Link class="btn btn-danger mr-2" :href="route('logout')">
            <i class="fas fa-sign-out-alt"></i>
            </Link>
        </div>
    </div>

    <!-- Контент -->
    <div class="flex-grow-1 py-4 d-flex justify-content-center">
        <!-- Таб "Вся музыка" -->
        <div v-if="activeTab === 'tracks'" class="container">
            <div v-for="track in tracks" :key="track.id" class="card bg-white text-black mb-3 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-text mb-1">
                            <span class="fw-bold"> {{ track.title }}</span>
                        </p>
                        <p class="card-text mb-1">
                            <span class="fw-bold">Орындаушы:</span> {{ track.artist }}
                        </p>
                        <p class="card-text mb-1">
                            <span class="fw-bold">Жанры:</span> {{ track.genre }}
                        </p>
                        <p class="card-text">
                            <span class="fw-bold">Альбомы:</span> {{ track.album ? track.album.title : '-' }}
                        </p>
                    </div>
                    <audio :src="'/storage/' + track.file_path" controls class="w-50"></audio>
                    <div class="bg-success add" @click="saveTrack(track.id)" title="Сохранить">
                        <p class="addText">+</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Таб "Альбомы" -->
        <div v-if="activeTab === 'albums'" class="container">
            <div v-for="album in albums" :key="album.id" class="card bg-secondary text-white mb-3 shadow-sm">
                <div class="card-body c-p">
                    <div class="d-flex align-items-center gap-3 justify-content-between">
                        <h5 class="card-title cursor-pointer text-white" @click="toggleAlbum(album.id)">
                            {{ album.title }}
                        </h5>
                        <div class="bg-success add customAdd" @click="saveAlbum(album.id)" title="Сохранить">
                            <p class="addText">+</p>
                        </div>
                    </div>
                    <br>
                    <div v-if="activeAlbum === album.id" class="mt-3">
                        <div v-for="track in album.tracks" :key="track.id" class="card bg-white text-dark mb-2 shadow-sm">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="card-text mb-1">
                                        <span class="fw-bold"> {{ track.title }}</span>
                                    </p>
                                    <p class="card-text mb-1">
                                        <span class="fw-bold">Орындаушы:</span> {{ track.artist }}
                                    </p>
                                    <p class="card-text mb-0">
                                        <span class="fw-bold">Жанры:</span> {{ track.genre }}
                                    </p>
                                </div>
                                <audio :src="'/storage/' + track.file_path" controls class="w-50"></audio>
                                <div class="bg-success add" @click="saveTrack(track.id)" title="Сохранить">
                                    <p class="addText">+</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="activeTab === 'myTracks'" class="container">
            <div class="card bg-white text-black mb-3 shadow-sm" v-if="myTracks.length < 1">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-text mb-1">
                            <span class="fw-bold">Әзірге ештеңе жоқ!</span>
                        </p>
                    </div>
                </div>
            </div>
            <div v-for="myTrack in myTracks" :key="myTrack.id" class="card bg-white text-black mb-3 shadow-sm" v-else>
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-text mb-1">
                            <span class="fw-bold"> {{ myTrack.title }}</span>
                        </p>
                        <p class="card-text mb-1">
                            <span class="fw-bold">Орындаушы:</span> {{ myTrack.artist }}
                        </p>
                        <p class="card-text mb-1">
                            <span class="fw-bold">Жанры:</span> {{ myTrack.genre }}
                        </p>
                        <p class="card-text">
                            <span class="fw-bold">Альбомы:</span> {{ myTrack.album ? myTrack.album.title : '-' }}
                        </p>
                    </div>
                    <audio :src="'/storage/' + myTrack.file_path" controls class="w-50"></audio>
                    <div class="bg-danger add delete" @click="deleteMyTrack(myTrack.id)" title="Удалить">
                        <p class="addText">-</p>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="activeTab === 'myAlbums'" class="container">
            <div class="card bg-white text-black mb-3 shadow-sm" v-if="myAlbums.length < 1">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-text mb-1">
                            <span class="fw-bold">Әзірге ештеңе жоқ!</span>
                        </p>
                    </div>
                </div>
            </div>
            <div v-for="album in myAlbums" :key="album.id" class="card bg-secondary text-white mb-3 shadow-sm" v-else>
                <div class="card-body c-p">
                    <div class="d-flex align-items-center gap-3 justify-content-between">
                        <h5 class="card-title cursor-pointer text-white" @click="toggleAlbum(album.id)">
                            {{ album.title }}
                        </h5>
                        <div class="bg-danger add delete customAdd" @click="deleteMyAlbum(album.id)" title="Сохранить">
                            <p class="addText">-</p>
                        </div>
                    </div>
                    <br>
                    <div v-if="activeAlbum === album.id" class="mt-3">
                        <div v-for="track in album.tracks" :key="track.id" class="card bg-white text-dark mb-2 shadow-sm">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="card-text mb-1">
                                        <span class="fw-bold"> {{ track.title }}</span>
                                    </p>
                                    <p class="card-text mb-1">
                                        <span class="fw-bold">Орындаушы:</span> {{ track.artist }}
                                    </p>
                                    <p class="card-text mb-0">
                                        <span class="fw-bold">Жанры:</span> {{ track.genre }}
                                    </p>
                                </div>
                                <audio :src="'/storage/' + track.file_path" controls class="w-50"></audio>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import { Link} from "@inertiajs/inertia-vue3";
export default {
    components: {
        Link,
    },
    props: {
        tracks: {
            type: Array,
            required: true,
        },
        albums: {
            type: Array,
            required: true,
        },
        myTracks: {
            type: Array,
            required: true,
        },
        myAlbums: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            activeTab: "tracks",
            activeAlbum: null,
            filter: {
                title: route().params.title ? route().params.title : null,
            },
        };
    },
    methods: {
        saveTrack(id) {
            this.$inertia.post(
                route("saveTrack"), { music_id: id },
            );
        },
        deleteMyTrack(id) {
            this.$inertia.post(
                route("deleteMyTrack"), { music_id: id },
            );
        },
        saveAlbum(id) {
            this.$inertia.post(
                route("saveAlbum"), { album_id: id },
            );
        },
        deleteMyAlbum(id) {
            this.$inertia.post(
                route("deleteMyAlbum"), { album_id: id },
            );
        },
        toggleAlbum(id) {
            this.activeAlbum = this.activeAlbum === id ? null : id;
        },
        search() {
            this.loading = 1
            const params = this.clearParams(this.filter);
            this.$inertia.get(route('main'), params)
        },
    },
};
</script>

<style scoped>
.c-p {
    cursor: pointer;
}

.card-title.cursor-pointer {
    cursor: pointer;
}

.add {
    border-radius: 50%;
    padding: 0 8px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.add:hover {
    padding: 4px 12px;
}

.addText {
    font-size: 22px;
    font-weight: bold;
}

.delete {
    padding: 0 9.5px;
}

.delete:hover {
    padding: 4px 14px;
}

.customAdd {
    margin-bottom: 0.75rem;
}
</style>
