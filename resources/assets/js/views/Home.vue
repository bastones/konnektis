<template>
    <div v-if="loading" class="loading text-center">
        <i class="fas fa-circle-notch fa-spin"></i>
    </div>

    <div v-else class="container pt-4 pb-4">
        <form @submit.prevent="submitForm" novalidate>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>
                                Full Name
                            </td>

                            <td>
                                Email Address
                            </td>

                            <td>
                                Phone No.

                                <a v-if="! form.show" href="javascript:;" class="text-secondary" @click="showForm">
                                    <i class="fas fa-plus-circle"></i>
                                </a>

                                <a v-else href="javascript:;" class="text-danger" @click="hideForm">
                                    <i class="fas fa-minus-circle"></i>
                                </a>
                            </td>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-if="form.show">
                            <td>
                                <input type="text"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors && typeof form.errors.name !== typeof undefined }"
                                       @keydown="removeError('name')"
                                       placeholder="What's the full name?"
                                       v-model="form.data.name"
                                       ref="name">

                                <div class="invalid-feedback"
                                     v-if="form.errors && typeof form.errors.name !== typeof undefined"
                                     v-text="form.errors.name[0]"></div>
                            </td>

                            <td>
                                <input type="email"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors && typeof form.errors.email !== typeof undefined }"
                                       @keydown="removeError('email')"
                                       placeholder="What's the email address?"
                                       v-model="form.data.email">

                                <div class="invalid-feedback"
                                     v-if="form.errors && typeof form.errors.email !== typeof undefined"
                                     v-text="form.errors.email[0]"></div>
                            </td>

                            <td class="d-flex flex-row">
                                <div class="w-100 mr-3">
                                    <input type="text"
                                           class="form-control"
                                           :class="{ 'is-invalid': form.errors && typeof form.errors.phone !== typeof undefined }"
                                           @keydown="removeError('phone')"
                                           placeholder="What's the phone number?"
                                           v-model="form.data.phone">


                                    <div class="invalid-feedback"
                                         v-if="form.errors && typeof form.errors.phone !== typeof undefined"
                                         v-text="form.errors.phone[0]"></div>
                                </div>

                                <div class="d-inline-block">
                                    <button class="btn btn-secondary" :disabled="refreshing">
                                        Add
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <template v-for="person in people">
                            <tr>
                                <td v-text="person.name"></td>

                                <td v-text="person.email"></td>

                                <td v-text="person.phone"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </form>

        <nav>
            <paginate
                    v-model="page"
                    :page-count="meta.last_page"
                    :page-range="3"
                    :margin-pages="2"
                    :click-handler="getPaginatedResults"
                    :prev-text="'Prev'"
                    :next-text="'Next'"
                    container-class="pagination justify-content-center mt-4"
                    page-class="page-item"
                    disabled-class="page-item disabled"
                    next-class="page-item"
                    prev-link-class="page-link"
                    next-link-class="page-link"
                    page-link-class="page-link">
            </paginate>
        </nav>

        <div v-if="refreshing" class="refreshing text-center d-none d-sm-block">
            <i class="fas fa-circle-notch fa-spin"></i>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                people: [],
                meta: [],
                page: 1,

                form: {
                    show: false,

                    errors: null,

                    data: {
                        name: '',
                        email: '',
                        phone: '',
                    },
                },

                loading: true,
                refreshing: false,
            };
        },

        methods: {
            getPeople() {
                axios.get('/api/people?page=' + this.page).then(HttpResponse => {
                    let data = HttpResponse.data;

                    this.people = data.data;
                    this.meta = data.meta;

                    this.loading = false;
                    this.refreshing = false;

                    this.form.show = false;
                    this.emptyForm();
                });
            },

            getPaginatedResults() {
                this.refreshing = true;

                this.getPeople();
            },

            showForm() {
                this.form.show = true;

                this.$nextTick(() => {
                    this.$refs.name.focus();
                });
            },

            hideForm() {
                this.form.show = false;

                this.emptyForm();
            },

            emptyForm() {
                this.form.errors = null;
                this.form.data.name = '';
                this.form.data.email = '';
                this.form.data.phone = '';
            },

            submitForm() {
                this.refreshing = true;

                axios.post('/api/people', this.form.data).then(HttpResponse => {
                    if (HttpResponse.data.success) {
                        this.getPeople();
                    }
                }).catch(HttpResponse => {
                    if (typeof HttpResponse.response.data.errors !== typeof undefined) {
                        this.form.errors = HttpResponse.response.data.errors;
                    }

                    this.refreshing = false;

                    this.$nextTick(() => {
                        this.$refs.name.focus();
                    });
                });
            },

            removeError(key) {
                if (this.form.errors && typeof this.form.errors[key] !== typeof undefined) {
                    delete this.form.errors[key];
                }
            },
        },

        mounted() {
            //
        },

        created() {
            document.title = 'Welcome to Konnektis';

            this.getPeople();
        },
    };
</script>

<style scoped>
    @media (max-width: 992px) {
        .table td,
        .table td > div:first-child {
            min-width: 250px;
        }
    }

    .table > thead > tr > td {
        position: relative;
    }

    .table > thead > tr > td > a {
        position: absolute;
        top: 6px;
        right: 2px;
        font-size: 18px;
        padding: 5px 8px;
    }
</style>
