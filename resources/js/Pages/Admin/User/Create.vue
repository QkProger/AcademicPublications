<template>

    <head>
        <title>{{ userData.lang_code == 'kz' ? 'Админ панель | Қызметкер қосу' : 'Yönetici Paneli | Personel  Ekle' }}
        </title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        {{ userData.lang_code == 'kz' ? 'Қызметкер қосу' : 'Personel  ekle' }}
                    </h1>
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
                            <a :href="route('admin.users.index')">
                                <i class="fas fa-dashboard"></i>
                                {{ userData.lang_code == 'kz' ? 'Қызметкерлер тізімі' : 'Personellerın listesi' }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ userData.lang_code == 'kz' ? 'Қызметкер қосу' : 'Personel  ekle' }}
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
                            <label for="">{{ userData.lang_code == 'kz' ? 'Аты' : 'Adı' }}</label>
                            <input type="text" class="form-control" v-model="user.name" name="name" />
                            <validation-error :field="'name'" />
                        </div>
                        <div class="form-group">
                            <label for="">{{ userData.lang_code == 'kz' ? 'Әкесінің аты' : 'Baba Adı' }}</label>
                            <input type="text" class="form-control" v-model="user.second_name" name="second_name" />
                            <validation-error :field="'second_name'" />
                        </div>
                        <div class="form-group">
                            <label for="">{{ userData.lang_code == 'kz' ? 'Фамилия' : 'Soyadı' }}</label>
                            <input type="text" class="form-control" v-model="user.surname" name="surname" />
                            <validation-error :field="'surname'" />
                        </div>
                        <div class="form-group">
                            <label for="">{{ userData.lang_code == 'kz' ? 'Телефон номері' : 'Telefon Numarası'
                                }}</label>
                            <input type="text" class="form-control" v-model="user.phone" name="phone" />
                            <validation-error :field="'phone'" />
                        </div>
                        <div class="form-group">
                            <label for="">{{ userData.lang_code == 'kz' ? 'ИИН' : 'IIN' }}</label>
                            <input type="number" class="form-control" v-model="user.iin" name="iin" />
                            <validation-error :field="'iin'" />
                        </div>
                        <div class="form-group">
                            <label for="">{{ userData.lang_code == 'kz' ? 'Почтасы' : 'E-posta' }}</label>
                            <input type="text" class="form-control" v-model="user.email" name="email" />
                            <validation-error :field="'email'" />
                        </div>
                        <div class="form-group">
                            <label for="">{{ userData.lang_code == 'kz' ? 'Қызметі' : 'Görevi' }}</label>
                            <input type="text" class="form-control" v-model="user.job" name="job" />
                            <validation-error :field="'job'" />
                        </div>
                        <div class="form-group">
                            <label for="">{{ userData.lang_code == 'kz' ? 'Құпия сөзі' : 'Parola' }}</label>
                            <input type="text" class="form-control" v-model="user.real_password" name="real_password" />
                            <validation-error :field="'real_password'" />
                        </div>
                        <div class="form-group">
                            <label for="">{{ userData.lang_code == 'kz' ? 'Рөлдер' : 'Rolleri' }}</label>
                            <div class="ml33">
                                <multiselect v-model="user.selectedRoles" :options="filteredRoles" :multiple="true"
                                    :taggable="true" :placeholder=rolChoose label="name" :hide-selected="true"
                                    :close-on-select="false" :searchable="false" track-by="id" class="mt-3 ml-3">
                                </multiselect>
                            </div>
                        </div>
                    </div>
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
        'roles',
        'exist1',
        'exist2',
    ],
    data() {
        return {
            user: {

            },
        }
    },
    created() {
        this.$store.dispatch('fetchUser');
    },
    computed: {
        rolChoose() {
            return this.$store.getters.getUserData.user.lang_code === 'kz' ? 'Рөлдерді таңдаңыз' : 'Rolleri seçin'
        },
        userData() {
            return this.$store.getters.getUserData.user;
        },
        selectedRoleIds: function () {
            return this.user.selectedRoles.map(role => role.id);
        },
        filteredRoles() {
            let filtered = this.roles;

            if (this.exist1 === 1 && this.exist2 === 1) {
                filtered = filtered.filter(role => role.id !== 3 && role.id !== 4);
            } else {
                if (this.exist1 === 1) {
                    filtered = filtered.filter(role => role.id !== 3);
                }
                if (this.exist2 === 1) {
                    filtered = filtered.filter(role => role.id !== 4);
                }
            }

            return filtered;
        }

    },
    methods: {
        submit() {
            this.user.selectedRoles = this.selectedRoleIds;
            this.$inertia.post(
                route("admin.users.store"),
                this.user,
            );
        },
    },
};
</script>
<style>
.ml33 {
    margin-left: -1rem !important;
    margin-top: -1rem !important;
    margin-right: 1rem;
}
</style>