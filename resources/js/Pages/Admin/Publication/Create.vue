<template>
    <head>
        <title>Админ панель | Басылым қосу</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Басылым қосу</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a :href="route('admin.index')">
                                <i class="fas fa-dashboard"></i>
                                Басты бет
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a :href="route('admin.publications.index')">
                                <i class="fas fa-dashboard"></i>
                                Басылымдар тізімі
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Басылым қосу
                        </li>
                    </ol>
                </div>
            </div>
        </template>

        <div class="container-fluid">
            <div class="card card-primary">
                <form method="post" @submit.prevent="submit">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Аты</label>
                            <input type="text" class="form-control" v-model="publication.title" name="title" />
                        </div>
                        <div class="form-group">
                            <label for="">Жылы</label>
                            <input type="text" class="form-control" v-model="publication.publication_year" name="publication_year" />
                        </div>
                        <div class="form-group">
                            <label for="">Типі</label>
                            <select class="form-control" v-model="publication.publication_type" name="publication_type">
                                <option v-for="type in types" :value="type">{{ type }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Журналы</label>
                            <select class="form-control" v-model="publication.journal_id" name="journals_id">
                                <option v-for="journal in journals" :value="journal.id">{{ journal.name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Сандық Нысан Идентификаторы</label>
                            <input type="text" class="form-control" v-model="publication.doi" name="doi" />
                        </div>

                        <!-- Множество авторов -->
                        <div class="form-group">
                            <label for="">Авторы</label>
                            <br>
                            <div v-for="(author, index) in authorsList" :key="index" class="d-flex mb-3">
                                <!-- Селектор для выбора автора -->
                                <select class="form-control mr-2" v-model="author.id" :name="'author_id_' + index">
                                    <option v-for="authorItem in authors" :value="authorItem.id">
                                        {{ authorItem.full_name }}
                                    </option>
                                </select>

                                <!-- Селектор для выбора роли -->
                                <select class="form-control mr-2" v-model="author.role" :name="'author_role_' + index">
                                    <option value="Бас автор">Бас автор</option>
                                    <option value="Соавтор">Соавтор</option>
                                </select>

                                <!-- Кнопка удаления автора -->
                                <button type="button" class="btn btn-danger ml-2" @click="removeAuthor(index)">Жою</button>
                            </div>

                            <!-- Кнопка добавления нового автора -->
                            <button type="button" class="btn btn-secondary" @click="addAuthor">Автор қосу</button>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-1">
                            Сақтау
                        </button>
                        <button type="button" class="btn btn-danger" @click.prevent="back()">
                            Артқа
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

<script>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import { Link, Head } from "@inertiajs/inertia-vue3";
import Pagination from "../../../Components/Pagination.vue";
import ValidationError from "../../../Components/ValidationError.vue";

export default {
    components: {
        AdminLayout,
        Link,
        Pagination,
        ValidationError,
        Head
    },
    props: [
        'journals',
        'authors', // Существующие авторы
    ],
    data() {
        return {
            publication: {
                publication_type: 'Мақала',
                journal_id: this.journals[0].id,
                authors: [] // Массив для авторов
            },
            types: ['Мақала', 'Тезис', 'Монография', 'Патент'],
            authorsList: [] // Динамически добавляемые авторы с их ролью
        }
    },
    created() {
        this.$store.dispatch('fetchUser');
    },
    computed: {
        userData() {
            return this.$store.getters.getUserData.user;
        }
    },
    methods: {
        addAuthor() {
            // Добавляем новый объект с автором и ролью по умолчанию
            this.authorsList.push({ id: '', role: 'Бас автор' });
        },
        removeAuthor(index) {
            // Удаляем автора по индексу
            this.authorsList.splice(index, 1);
        },
        submit() {
            // Преобразуем данные авторов перед отправкой
            this.publication.authors = this.authorsList.map(author => ({
                author_id: author.id,
                role: author.role,
            }));

            // Отправляем данные публикации
            this.$inertia.post(
                route("admin.publications.store"),
                this.publication,
                {
                    onError: () => console.log("An error has occurred"),
                    onSuccess: () =>
                        console.log("The new publication has been saved"),
                }
            );
        },
    },
};
</script>
