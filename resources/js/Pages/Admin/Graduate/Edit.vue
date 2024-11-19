<template>

    <head>
        <title v-if="userData.lang_code == 'kz'">Админ панель | Түлек ақпаратын өзгерту</title>
        <title v-else>Админ панель | Түлек ақпаратын өзгерту</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
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
                            <a :href="route('admin.roles.index')" v-if="userData.lang_code == 'kz'">
                                <i class="fas fa-dashboard"></i>
                                Түлектер тізімі
                            </a>
                            <a :href="route('admin.roles.index')" v-else>
                                <i class="fas fa-dashboard"></i>
                                Түлектер тізімі
                            </a>
                        </li>
                        <li class="breadcrumb-item active" v-if="userData.lang_code == 'kz'">
                            Түлек ақпаратын өзгерту
                        </li>
                        <li class="breadcrumb-item active" v-else>
                            Түлек ақпаратын өзгерту
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
                            <label for="" >Аты</label>
                            <input type="text" class="form-control" v-model="graduate.firstName" name="firstName" />
                        </div>
                        <div class="form-group">
                            <label for="" >Фамилия</label>
                            <input type="text" class="form-control" v-model="graduate.lastName" name="lastName" />
                        </div>
                        <div class="form-group">
                            <label for="" >Әкесі</label>
                            <input type="text" class="form-control" v-model="graduate.patronymic" name="patronymic" />
                        </div>
                        <div class="form-group">
                            <label for="" >Туған күні</label>
                            <input type="date" class="form-control" v-model="graduate.birthDate" name="birthDate" />
                        </div>
                        <div class="form-group">
                            <label for="" >ЖСН/ИИН</label>
                            <input type="text" class="form-control" v-model="graduate.iinPlt" name="iinPlt" />
                        </div>
                        <div class="form-group">
                            <label for="sexId">Жынысы</label>
                            <select class="form-control" v-model="graduate.sexId" name="sexId">
                                <option value="" disabled selected>Жынысты таңдаңыз</option>
                                <option value="1">Әйел</option> <!-- Women (ID = 1) -->
                                <option value="2">Ер</option>    <!-- Men (ID = 2) -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Оқу түрі</label>
                            <select class="form-control" v-model="graduate.studyFormId">
                                <option :value="studyForm.id" v-for="studyForm in studyForms" :key="studyForm.id">{{ studyForm.nameKz }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Төлем түрі</label>
                            <select class="form-control" v-model="graduate.paymentFormId">
                                <option :value="paymentform.id" v-for="paymentform in paymentforms" :key="paymentform.id">{{ paymentform.nameKz }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Оқу тілі</label>
                            <select class="form-control" v-model="graduate.studyLanguageId">
                                <option :value="studylanguage.id" v-for="studylanguage in studylanguages" :key="studylanguage.id">{{ studylanguage.nameKz }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Мамандық</label>
                            <select class="form-control" v-model="graduate.professionId">
                                <option :value="profession.professionId" v-for="profession in professions">{{ profession.professionNameKz }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="hasJob">Жұмыс орны барма</label>
                            <select class="form-control" v-model="graduate.hasJob" name="hasJob">
                                <option value="" disabled selected>Таңдаңыз</option>
                                <option value="True">Ия</option> <!-- Women (ID = 1) -->
                                <option value="False">Жоқ</option> <!-- Men (ID = 2) -->
                            </select>
                        </div>
                        <div v-if="graduate.hasJob == 'True'" class="form-group">
                            <label for="">Жұмыс Орны</label>
                            <input type="text" class="form-control" v-model="graduate.jobPlace" name="jobPlace" />
                        </div>
                        <div class="form-group">
                            <label for="">gpa</label>
                            <input type="text" class="form-control" v-model="graduate.gpa" name="gpa" />
                        </div>
                        <div class="form-group">
                            <label for="">Оқуды бітіру туралы бастауномері</label>
                            <input type="text" class="form-control" v-model="graduate.startOrderNumber" name="startOrderNumber" />
                        </div>
                        <div class="form-group">
                            <label for="">Оқуды бітіру туралы бастауномері</label>
                            <input type="text" class="form-control" v-model="graduate.finishOrderNumber" name="finishOrderNumber" />
                        </div>
                        <div class="form-group">
                            <label for="">Диплом сериясы</label>
                            <input type="text" class="form-control" v-model="graduate.finishDiplomSeries" name="finishDiplomSeries" />
                        </div>
                        <div class="form-group">
                            <label for="">Бітіру уақыты</label>
                            <input type="date" class="form-control" v-model="graduate.finishDocDate" name="finishDocDate" />
                        </div>
                        <div class="form-group">
                            <label for="">Қорғаған докторант</label>
                            <input type="text" class="form-control" v-model="graduate.doctorDefended" name="doctorDefended" />
                        </div>
                        <div class="form-group">
                            <label for="">Академиялық дәреже</label>
                            <select class="form-control" v-model="graduate.degreeId">
                                <option :value="degree.degreeId" v-for="degree in degrees">{{ degree.nameKz }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for=""> Алғаш оқуға қабылдау күні</label>
                            <input type="date" class="form-control" v-model="graduate.startDate" name="startDate" />
                        </div>
                        <div class="form-group">
                            <label for="">Оқуды бітіру туралы бұйрық күні</label>
                            <input type="date" class="form-control" v-model="graduate.finishOrderDate" name="finishOrderDate" />
                        </div>
                        <div class="form-group">
                            <label for="">Диплом номері</label>
                            <input type="text" class="form-control" v-model="graduate.finishDiplomNumber" name="finishDiplomNumber" />
                        </div>
                        <div class="form-group">
                            <label for="">Мамандық коды</label>
                            <select class="form-control" v-model="graduate.centerProfessionCode">
                                <option :value="centerprofession.code" v-for="centerprofession in centerprofessions">{{ centerprofession.nameKz }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Бұрынғы универ аты</label>
                            <input type="text" class="form-control" v-model="graduate.oldUniversityName" name="oldUniversityName" />
                        </div>
                        <div class="form-group">
                            <label for="">телефон</label>
                            <input type="text" class="form-control" v-model="graduate.phone" name="phone" />
                        </div>
                        <div class="form-group">
                            <label for="">Ұялы телефон</label>
                            <input type="text" class="form-control" v-model="graduate.mobilePhone" name="mobilePhone" />
                        </div>
                        <div class="form-group">
                            <label for="">Азаматтығы</label>
                            <select class="form-control" v-model="graduate.sitizenshipId">
                                <option :value="centercountrie.id" v-for="centercountrie in centercountries">{{ centercountrie.nameKz }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Аты Ағылшынша</label>
                            <input type="text" class="form-control" v-model="graduate.firstNameEn" name="firstNameEn" />
                        </div>
                        <div class="form-group">
                            <label for="">Фамилия Ағылшынша</label>
                            <input type="text" class="form-control" v-model="graduate.lastNameEn" name="lastNameEn" />
                        </div>
                        <div class="form-group">
                            <label for="">Әкесі аты Ағылшынша</label>
                            <input type="text" class="form-control" v-model="graduate.patronymicEn" name="patronymicEn" />
                        </div>
                        <div class="form-group">
                            <label for="">Мекеме типін нақтылау</label>
                            <select class="form-control" v-model="graduate.organizationType">
                                <option :value="organizationtype.id" v-for="organizationtype in organizationtypes">{{ organizationtype.nameKz }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Проток күні</label>
                            <input type="date" class="form-control" v-model="graduate.protocolDate" name="protocolDate" />
                        </div>
                        <div class="form-group">
                            <label for="">Проток нөмері</label>
                            <input type="text" class="form-control" v-model="graduate.protocolNumber" name="protocolNumber" />
                        </div>
                        <div class="form-group">
                            <label for="">Дипломның тіркеу номері</label>
                            <input type="text" class="form-control" v-model="graduate.regDiplomNumber" name="regDiplomNumber" />
                        </div>
                        <div class="form-group">
                            <label for="">Білімгердің ЕПВО Коды</label>
                            <input type="number" class="form-control" v-model="graduate.studentId" name="studentId" />
                        </div>
                        <div class="form-group">
                            <label for="">Құжат номері</label>
                            <input type="text" class="form-control" v-model="graduate.icNumber" name="icNumber" />
                        </div>
                        <div class="form-group">
                            <label for="">Құжаттың берілу күні</label>
                            <input type="date" class="form-control" v-model="graduate.icDate" name="icDate" />
                        </div>
                        <div class="form-group">
                            <label for="">Құжат берген Мекеме</label>
                            <select class="form-control" v-model="graduate.icDepartment">
                                <option :value="graduate.icDepartment" >{{ graduate.icDepartment }}</option>
                                <option :value="icdepartment.id" v-for="icdepartment in icdepartments">{{ icdepartment.nameKz }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Ұлты</label>
                            <select class="form-control" v-model="graduate.nationId">n>
                                <option :value="center_nationalitie.id" v-for="center_nationalitie in center_nationalities">{{ center_nationalitie.nameKz }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Оқуға қабылдау сертификатының күні</label>
                            <input type="date" class="form-control" v-model="graduate.entCertDatePrint" name="entCertDatePrint" />
                        </div>
                        <div class="form-group">
                            <label for="">Оқуға қабылдау сертификатының номері</label>
                            <input type="text" class="form-control" v-model="graduate.certificate" name="certificate" />
                        </div>
                        <div class="form-group">
                            <label for="">Оқуға қабылдау сынағында жинаған балы</label>
                            <input type="number" class="form-control" v-model="graduate.rating" name="rating" />
                        </div>
                        <div class="form-group">
                            <label for="">Талапкердің бітірген оқу орнының атауы</label>
                            <input type="text" class="form-control" v-model="graduate.education" name="education" />
                        </div>
                        <div class="form-group">
                            <label for="">Жұмыс орны типі</label>
                            <select class="form-control" v-model="graduate.jobPlaceTypeId">
                                <option :value="jobplacetype.id" v-for="jobplacetype in jobplacetypes">{{ jobplacetype.nameKz }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Жұмысқа орналаспау себебі</label>
                            <select class="form-control" v-model="graduate.employmentReasonId">
                                <option :value="employmentreason.id" v-for="employmentreason in employmentreasons">{{ employmentreason.nameKz }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="isHonoursDiploma">Үздік диплом</label>
                            <select class="form-control" v-model="graduate.isHonoursDiploma" name="isHonoursDiploma">
                                <option value="" disabled selected>Таңдаңыз</option>
                                <option value="0">Ия</option> 
                                <option value="1">Жоқ</option> 
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="iinGivedByGovernment">ЖСН мемлекеттік органмен беріледі</label>
                            <select class="form-control" v-model="graduate.iinGivedByGovernment" name="iinGivedByGovernment">
                                <option value="" disabled selected>Таңдаңыз</option>
                                <option value="0">Ия</option> 
                                <option value="1">Жоқ</option> 
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Туған қаласы</label>
                            <input type="text" class="form-control" v-model="graduate.birthPlace" name="birthPlace" />
                        </div>
                        <div class="form-group">
                            <label for="diplomDuplicateGiven">Диплом көшірмесі берілді</label>
                            <select class="form-control" v-model="graduate.diplomDuplicateGiven" name="diplomDuplicateGiven">
                                <option value="" disabled selected>Таңдаңыз</option>
                                <option value="1">Ия</option> 
                                <option value="0">Жоқ</option> 
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Диплом көшірмесінің сериясы мен номері</label>
                            <input type="text" class="form-control" v-model="graduate.diplomDuplicateSeriesNumber" name="diplomDuplicateSeriesNumber" />
                        </div>
                        <div class="form-group">
                            <label for="">Диплом көшірмесінің тіркеу номері</label>
                            <input type="text" class="form-control" v-model="graduate.diplomDuplicateRegNumber" name="diplomDuplicateRegNumber" />
                        </div>
                        <div class="form-group">
                            <label for="">Құжат берген Мекеме</label>
                            <select class="form-control" v-model="graduate.icDepartmentId">
                                <option :value="icdepartment.id" v-for="icdepartment in icdepartments">{{ icdepartment.nameKz }}</option>
                            </select>
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
    props: ['employmentreasons','jobplacetypes','center_nationalities','icdepartments',"graduate",'studyForms','paymentforms','studylanguages',"professions",'degrees','centerprofessions','centercountries','organizationtypes'],
    created() {
        this.$store.dispatch('fetchUser');
    },
    computed: {
        userData() {
            return this.$store.getters.getUserData.user;
        }
    },
    methods: {
        submit() {
            this.$inertia.put(
                route("admin.graduates.update", this.graduate.id),
                this.graduate,
                {
                    onError: () => console.log("An error has occurred"),
                    onSuccess: () =>
                        console.log("The new contact has been saved"),
                }
            );
        },
    },
};
</script>
