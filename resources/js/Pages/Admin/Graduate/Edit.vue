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
                            <span class="text-danger">*</span>
                            <label for="">Аты</label>
                            <input type="text" class="form-control" v-model="graduate.firstName" name="firstName" />
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Фамилия</label>
                            <input type="text" class="form-control" v-model="graduate.lastName" name="lastName" />
                        </div>
                        <div class="form-group">
                            <label for="">Әкесі</label>
                            <input type="text" class="form-control" v-model="graduate.patronymic" name="patronymic" />
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Туған күні</label>
                            <input type="date" class="form-control" v-model="graduate.birthDate" name="birthDate" />
                        </div>
                        <div class="form-group">
                            <label for="">ЖСН/ИИН</label>
                            <input type="text" class="form-control" v-model="graduate.iinPlt" name="iinPlt" />
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="sexId">Жынысы</label>
                            <select class="form-control" v-model="graduate.sexId" name="sexId">
                                <option value="" disabled selected>Жынысты таңдаңыз</option>
                                <option value="1">Әйел</option> <!-- Women (ID = 1) -->
                                <option value="2">Ер</option> <!-- Men (ID = 2) -->
                            </select>
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Оқу түрі</label>
                            <select class="form-control" v-model="graduate.studyFormId">
                                <option :value="studyForm.id" v-for="studyForm in studyForms" :key="studyForm.id">{{
                                    studyForm.nameKz }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Төлем түрі</label>
                            <select class="form-control" v-model="graduate.paymentFormId">
                                <option :value="paymentform.id" v-for="paymentform in paymentforms"
                                    :key="paymentform.id">{{
                                    paymentform.nameKz }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Оқу тілі</label>
                            <select class="form-control" v-model="graduate.studyLanguageId">
                                <option :value="studylanguage.id" v-for="studylanguage in studylanguages"
                                    :key="studylanguage.id">{{ studylanguage.nameKz }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Мамандық</label>
                            <select class="form-control" v-model="graduate.professionId">
                                <option :value="profession.professionId" v-for="profession in professions">{{
                                    profession.professionNameKz }}</option>
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
                            <span class="text-danger">*</span>
                            <label for="">Оқуды бітіру туралы бастау номері</label>
                            <input type="text" class="form-control" v-model="graduate.startOrderNumber"
                                name="startOrderNumber" />
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Оқуды бітіру туралы бастау номері</label>
                            <input type="text" class="form-control" v-model="graduate.finishOrderNumber"
                                name="finishOrderNumber" />
                        </div>
                        <div class="form-group">
                            <label for="">Диплом сериясы</label>
                            <input type="text" class="form-control" v-model="graduate.finishDiplomSeries"
                                name="finishDiplomSeries" />
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Бітіру уақыты</label>
                            <input type="date" class="form-control" v-model="graduate.finishDocDate"
                                name="finishDocDate" />
                        </div>
                        <div class="form-group">
                            <label for="">Қорғаған докторант</label>
                            <input type="text" class="form-control" v-model="graduate.doctorDefended"
                                name="doctorDefended" />
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Академиялық дәреже</label>
                            <select class="form-control" v-model="graduate.degreeId">
                                <option :value="degree.degreeId" v-for="degree in degrees">{{ degree.nameKz }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for=""> Алғаш оқуға қабылдау күні</label>
                            <input type="date" class="form-control" v-model="graduate.startDate" name="startDate" />
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Оқуды бітіру туралы бұйрық күні</label>
                            <input type="date" class="form-control" v-model="graduate.finishOrderDate"
                                name="finishOrderDate" />
                        </div>
                        <div class="form-group">
                            <label for="">Диплом номері</label>
                            <input type="text" class="form-control" v-model="graduate.finishDiplomNumber"
                                name="finishDiplomNumber" />
                        </div>
                        <div class="form-group">
                            <label for="">Мамандық коды</label>
                            <select class="form-control" v-model="graduate.centerProfessionCode">
                                <option :value="centerprofession.code" v-for="centerprofession in centerprofessions">{{
                                    centerprofession.nameKz }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Бұрынғы универ аты</label>
                            <input type="text" class="form-control" v-model="graduate.oldUniversityName"
                                name="oldUniversityName" />
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
                            <span class="text-danger">*</span>
                            <label for="">Азаматтығы</label>
                            <select class="form-control" v-model="graduate.sitizenshipId">
                                <option :value="centercountrie.id" v-for="centercountrie in centercountries">{{
                                    centercountrie.nameKz }}</option>
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
                            <input type="text" class="form-control" v-model="graduate.patronymicEn"
                                name="patronymicEn" />
                        </div>
                        <div class="form-group">
                            <label for="">Мекеме типін нақтылау</label>
                            <select class="form-control" v-model="graduate.organizationType">
                                <option :value="organizationtype.id" v-for="organizationtype in organizationtypes">{{
                                    organizationtype.nameKz }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Протокол күні</label>
                            <input type="date" class="form-control" v-model="graduate.protocolDate"
                                name="protocolDate" />
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Протокол нөмері</label>
                            <input type="text" class="form-control" v-model="graduate.protocolNumber"
                                name="protocolNumber" />
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Дипломның тіркеу номері</label>
                            <input type="text" class="form-control" v-model="graduate.regDiplomNumber"
                                name="regDiplomNumber" />
                        </div>
                        <div class="form-group">
                            <label for="">Білімгердің ЕПВО Коды</label>
                            <input type="number" class="form-control" v-model="graduate.studentId" name="studentId" />
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Құжат номері</label>
                            <input type="text" class="form-control" v-model="graduate.icNumber" name="icNumber" />
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Құжаттың берілу күні</label>
                            <input type="date" class="form-control" v-model="graduate.icDate" name="icDate" />
                        </div>
                        
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Ұлты</label>
                            <select class="form-control" v-model="graduate.nationId">n>
                                <option :value="center_nationalitie.id"
                                    v-for="center_nationalitie in center_nationalities">{{
                                    center_nationalitie.nameKz }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Оқуға қабылдау сертификатының күні</label>
                            <input type="date" class="form-control" v-model="graduate.entCertDatePrint"
                                name="entCertDatePrint" />
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
                            <span class="text-danger">*</span>
                            <label for="">Талапкердің бітірген оқу орнының атауы</label>
                            <input type="text" class="form-control" v-model="graduate.education" name="education" />
                        </div>
                        <div class="form-group">
                            <label for="">Жұмыс орны типі</label>
                            <select class="form-control" v-model="graduate.jobPlaceTypeId">
                                <option :value="jobplacetype.id" v-for="jobplacetype in jobplacetypes">{{
                                    jobplacetype.nameKz }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Жұмысқа орналаспау себебі</label>
                            <select class="form-control" v-model="graduate.employmentReasonId">
                                <option :value="employmentreason.id" v-for="employmentreason in employmentreasons">{{
                                    employmentreason.nameKz }}</option>
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
                            <select class="form-control" v-model="graduate.iinGivedByGovernment"
                                name="iinGivedByGovernment">
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
                            <select class="form-control" v-model="graduate.diplomDuplicateGiven"
                                name="diplomDuplicateGiven">
                                <option value="" disabled selected>Таңдаңыз</option>
                                <option value="1">Ия</option>
                                <option value="0">Жоқ</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Диплом көшірмесінің сериясы мен номері</label>
                            <input type="text" class="form-control" v-model="graduate.diplomDuplicateSeriesNumber"
                                name="diplomDuplicateSeriesNumber" />
                        </div>
                        <div class="form-group">
                            <label for="">Диплом көшірмесінің тіркеу номері</label>
                            <input type="text" class="form-control" v-model="graduate.diplomDuplicateRegNumber"
                                name="diplomDuplicateRegNumber" />
                        </div>
                        <div class="form-group">
                            <label for="">Диплом көшірмесінің тіркеу уақыты</label>
                            <input type="date" class="form-control" v-model="graduate.diplomDuplicateIssueDate"
                                name="diplomDuplicateIssueDate" />
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Құжат берген Мекеме</label>
                            <select class="form-control" v-model="graduate.icDepartmentId">
                                <option :value="icdepartment.id" v-for="icdepartment in icdepartments">{{
                                    icdepartment.nameKz }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Нострификация туралы сертификат күні</label>
                            <input type="date" class="form-control" v-model="graduate.nostrificationCertificateDate"
                                name="nostrificationCertificateDate" />
                        </div>
                        <div class="form-group">
                            <label for="">Нострификация туралы сертификат номері</label>
                            <input type="number" class="form-control" v-model="graduate.nostrificationCertificateNumber"
                                name="nostrificationCertificateNumber" />
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Білім беру мекемесін бітірген</label>
                            <select class="form-control" v-model="graduate.educationalInstitution"
                                name="educationalInstitution">
                                <option value="" disabled selected>Таңдаңыз</option>
                                <option value="1">Ия</option> <!-- Women (ID = 1) -->
                                <option value="0">Жоқ</option> <!-- Men (ID = 2) -->
                            </select>
                        </div>
                        <div class="form-group" v-if="graduate.degreeId == 1">
                            <label for="">Қабылдау түрі</label>
                            <select class="form-control" v-model="graduate.enterExamType" name="enterExamType">
                                <option value="" disabled selected>Таңдаңыз</option>
                                <option value="ЕНТ">ЕНТ</option>
                                <option value="КТ">КТ</option>
                                <option value="Собеседование">Собеседование</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Қаржыландыру көзі</label>
                            <select class="form-control" v-model="graduate.granttype">
                                <option :value="granttype.id" v-for="granttype in granttypes">{{ granttype.nameKz }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for=""> Құжат түрі</label>
                            <select class="form-control" v-model="graduate.ictype">
                                <option :value="ictype.id" v-for="ictype in ictypes">{{ ictype.nameKz }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Тұрып жатқан қала</label>
                            <input type="text" class="form-control" v-model="graduate.livingAddress"
                                name="livingAddress" />
                        </div>
                        <div class="form-group" v-if="graduate.degreeId == 4">
                            <label for="">Мемлекеттік комиссияның шешім қабылдаған күні</label>
                            <input type="date" class="form-control" v-model="graduate.stateCommissionDecisionDate"
                                name="stateCommissionDecisionDate" />
                        </div>
                        <div class="form-group" v-if="graduate.degreeId == 4">
                            <label for="">Куәлік нөмірі</label>
                            <input type="number" class="form-control" v-model="graduate.certificateNumber"
                                name="certificateNumber" />
                        </div>
                        <div class="form-group" v-if="graduate.degreeId == 4">
                            <label for="">Куәлік cериясы</label>
                            <input type="text" class="form-control" v-model="graduate.certificateSeries"
                                name="certificateSeries" />
                        </div>
                        <div class="form-group" v-if="graduate.degreeId == 4">
                            <label for="">Куәліктің тіркеу нөмірі</label>
                            <input type="number" class="form-control" v-model="graduate.certificateRegistrationNumber"
                                name="certificateRegistrationNumber" />
                        </div>
                        <div class="form-group" v-if="graduate.degreeId == 4">
                            <label for="">Куәлік берілген күні</label>
                            <input type="date" class="form-control" v-model="graduate.certificateIssueDate"
                                name="certificateIssueDate" />
                        </div>
                        <div class="form-group" v-if="graduate.profession.classifier == 2">
                            <label for="">Білім беру бағдарламасы</label>
                            <input type="text" class="form-control" v-model="graduate.specializationId"
                                name="specializationId" />
                        </div>
                        <div class="form-group">
                            <label for="">Отбасылық жағдайы</label>
                            <select class="form-control" v-model="graduate.isMarried" name="hasJob">
                                <option value="" disabled selected>Таңдаңыз</option>
                                <option value="1">Үйленген</option> <!-- Women (ID = 1) -->
                                <option value="0">Үйленбеген</option> <!-- Men (ID = 2) -->
                            </select>
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Диплом нөмірі</label>
                            <input type="number" class="form-control" v-model="graduate.iacDiplomaNumber"
                                name="iacDiplomaNumber" />
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Диплом сериясы</label>
                            <input type="text" class="form-control" v-model="graduate.iacDiplomaSeries"
                                name="iacDiplomaSeries" />
                        </div>
                        <div class="form-group" v-if="graduate.degreeId == 4">
                            <label for="">Біліктілігі бар жоғары білім туралы диплом сериясы</label>
                            <input type="text" class="form-control" v-model="graduate.internIacDiplomaSeries"
                                name="internIacDiplomaSeries" />
                        </div>
                        <div class="form-group" v-if="graduate.degreeId == 4">
                            <label for="">Біліктілік берілген жоғары білім туралы дипломның нөмірі</label>
                            <input type="text" class="form-control" v-model="graduate.internIacDiplomaNumber"
                                name="internIacDiplomaNumber" />
                        </div>
                        <div class="form-group" v-if="graduate.degreeId == 4">
                            <label for="">Біліктілікті беру хаттамасының нөмірі</label>
                            <input type="text" class="form-control" v-model="graduate.internProtocolNumber"
                                name="internProtocolNumber" />
                        </div>
                        <div class="form-group" v-if="graduate.degreeId == 4">
                            <label for="">Хаттама күні (біліктілік берілген жоғары білім туралы диплом)</label>
                            <input type="date" class="form-control" v-model="graduate.internProtocolDate"
                                name="internProtocolDate" />
                        </div>
                        <div class="form-group" v-if="graduate.degreeId == 4">
                            <label for="">Біліктілік берілген жоғары білім туралы дипломның тіркеу нөмірі</label>
                            <input type="text" class="form-control" v-model="graduate.internRegistrationNumber"
                                name="internRegistrationNumber" />
                        </div>
                        <div class="form-group" v-if="graduate.degreeId == 4">
                            <label for="">Біліктілік берілген жоғары білім туралы диплом берілген күн</label>
                            <input type="date" class="form-control" v-model="graduate.internDateOfIssue"
                                name="internDateOfIssue" />
                        </div>
                        <div class="form-group" v-if="graduate.degreeId == 4">
                            <label for="">Үздік Диплом</label>
                            <select class="form-control" v-model="graduate.internHonoursDiploma" name="hasJob">
                                <option value="" disabled selected>Таңдаңыз</option>
                                <option value="1">Ия</option> <!-- Women (ID = 1) -->
                                <option value="0">Жоқ</option> <!-- Men (ID = 2) -->
                            </select>
                        </div>
                        <div class="form-group" v-if="graduate.degreeId == 6 || graduate.degreeId == 7">
                            <label for="">Басқа ЖЖОКБҰ-да диссертация қорғау</label>
                            <select class="form-control" v-model="graduate.defenseOfDissertationInOtherHpeo" name="v">
                                <option value="" disabled selected>Таңдаңыз</option>
                                <option value="1">Ия</option> <!-- Women (ID = 1) -->
                                <option value="0">Жоқ</option> <!-- Men (ID = 2) -->
                            </select>
                        </div>
                        <div class="form-group" v-if="graduate.defenseOfDissertationInOtherHpeo == 1">
                            <label for="">Диссертация қорғалатын ЖЖОКБҰ атауы</label>
                            <input type="number" class="form-control"
                                v-model="graduate.defenseOfDissertationOtherHpeoId"
                                name="defenseOfDissertationOtherHpeoId" />
                        </div>
                        <div class="form-group" v-if="graduate.degreeId == 6 || graduate.degreeId == 7">
                            <label for="">Диссертацияны қорғау күні</label>
                            <input type="date" class="form-control" v-model="graduate.dateDissertationDefense"
                                name="dateDissertationDefense" />
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Қазақ тілінде берілген академиялық дәреже</label>
                            <input type="text" class="form-control" v-model="graduate.awardedacademicdegreekz"
                                name="awardedacademicdegreekz" />
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Орыс тілінде берілген академиялық дәреже</label>
                            <input type="text" class="form-control" v-model="graduate.awardedacademicdegreeru"
                                name="awardedacademicdegreeru" />
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Ағылшын тілінде берілген академиялық дәреже</label>
                            <input type="text" class="form-control" v-model="graduate.awardedacademicdegreeen"
                                name="awardedacademicdegreeen" />
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Қазақ тілінде берілген біліктілік</label>
                            <input type="text" class="form-control" v-model="graduate.awardedqualificationkz"
                                name="awardedqualificationkz" />
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Орыс тілінде берілген біліктілік</label>
                            <input type="text" class="form-control" v-model="graduate.awardedqualificationru"
                                name="awardedqualificationru" />
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="">Ағылшын тілінде берілген біліктілік</label>
                            <input type="text" class="form-control" v-model="graduate.awardedqualificationen"
                                name="awardedqualificationen" />
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
    props: ['employmentreasons', 'jobplacetypes', 'center_nationalities', 'icdepartments', "graduate", 'studyForms', 'paymentforms', 'studylanguages', "professions", 'degrees', 'centerprofessions', 'centercountries', 'organizationtypes', 'ictypes', 'granttypes'],
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
<style>
.text-danger{
    color: red;
}
/* <span class="text-danger">*</span> */
</style>
