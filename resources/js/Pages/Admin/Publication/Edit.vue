<template>
    <head>
        <title>Админ панель | Басылымды өңдеу</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Басылымды өңдеу</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a :href="route('admin.index')">
                                <i class="fas fa-dashboard"></i>
                                {{ userData.lang_code == 'kz' ? 'Басты бет' : 'Ana sayfa' }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a :href="route('admin.publications.index')">
                                <i class="fas fa-dashboard"></i>
                                Басылымдар тізімі
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Басылымды өңдеу
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
                            <label for="">Авторлар</label>
                            <br>
                            <div v-for="(author, index) in authorsList" :key="index" class="d-flex mb-3">
                                <!-- Селектор для выбора автора -->
                                <select class="form-control mr-2" v-model="author.author_id" :name="'author_id_' + index">
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
                    {{ publication.journal_id }}
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-1">
                            {{ userData.lang_code == 'kz' ? 'Сақтау' : 'Kaydet' }}
                        </button>
                        <button type="button" class="btn btn-danger" @click.prevent="back()">
                            {{ userData.lang_code == 'kz' ? 'Артқа' : 'Dönüş' }}
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
        'publicationn', // Публикация с уже существующими данными
        'authors',     // Список авторов
        'journals'     // Список журналов
    ],
    created() {
        this.$store.dispatch('fetchUser');
        // Если публикация имеет авторов, то подгружаем их в authorsList
        if (this.publicationn.authors && this.publicationn.authors.length > 0) {
            this.publicationn.authors.forEach(author => {
                this.addAuthor(author.id, author.pivot.role);
            });
        }
    },
    data() {
        return {
            publication: {
                id: this.publicationn.id,
                publication_type: 'Мақала',
                journal_id: this.publicationn.journal_id || '',
                title: this.publicationn.title || '',
                publication_year: this.publicationn.publication_year || '',
                doi: this.publicationn.doi || '',
                authors: this.publicationn.authors || [],
            },
            types: ['Мақала', 'Тезис', 'Монография', 'Патент'],
            authorsList: [] // Массив для хранения выбранных авторов с их ролями
        }
    },
    computed: {
        userData() {
            return this.$store.getters.getUserData.user;
        }
    },
    methods: {
        // Добавление нового автора в список
        addAuthor(authorId = null, role = 'Бас автор') {
            this.authorsList.push({
                author_id: authorId,
                role: role
            });
        },

        // Удаление автора из списка
        removeAuthor(index) {
            this.authorsList.splice(index, 1);
        },

        // Отправка формы
        submit() {
            this.publication.authors = this.authorsList.map(author => ({
                author_id: author.author_id,
                role: author.role
            }));

            // Подготовка данных для отправки
            this.publication["_method"] = "put";
            this.$inertia.post(
                route("admin.publications.update", this.publication.id),
                this.publication,
                {
                    onError: () => console.log("An error has occurred"),
                    onSuccess: () => console.log("The publication has been updated"),
                }
            );
        },

        // Возврат на предыдущую страницу
        back() {
            this.$inertia.visit(route('admin.publications.index'));
        }
    },
};
</script>
