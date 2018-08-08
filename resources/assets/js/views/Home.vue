<template>
    <div v-if="loading" class="loading text-center">
        <i class="fas fa-circle-notch fa-spin"></i>
    </div>

    <div v-else class="container pt-4 pb-4">
        <form @submit.prevent="submitForm" @keydown.esc="hideForm" novalidate>
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
                            </td>

                            <td>
                                <div class="float-right" v-if="people.length">
                                    <a v-if="! form.show" href="javascript:;" class="text-secondary" @click="showForm">
                                        <i class="fas fa-plus-circle"></i>
                                    </a>

                                    <a v-else href="javascript:;" class="text-danger" @click="hideForm">
                                        <i class="fas fa-minus-circle"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-if="form.show || ! people.length">
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

                            <td>
                                <input type="text"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors && typeof form.errors.phone !== typeof undefined }"
                                       @keydown="removeError('phone')"
                                       placeholder="What's the phone number?"
                                       v-model="form.data.phone">


                                <div class="invalid-feedback"
                                     v-if="form.errors && typeof form.errors.phone !== typeof undefined"
                                     v-text="form.errors.phone[0]"></div>
                            </td>

                            <td>
                                <button class="btn btn-block btn-secondary" :disabled="refreshing">
                                    Add
                                </button>
                            </td>
                        </tr>

                        <template v-for="person in people">
                            <tr>
                                <td v-text="person.name"></td>

                                <td v-text="person.email"></td>

                                <td v-text="person.phone"></td>

                                <td>
                                    <div class="dropdown float-right">
                                        <a href="javascript:;" class="text-secondary" data-toggle="dropdown" aria-haspopup="true"
                                           id="options"
                                           aria-expanded="false">
                                            <i class="fas fa-cog"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="options">
                                            <a class="dropdown-item" href="#">
                                                Edit...
                                            </a>

                                            <a class="dropdown-item" href="#">
                                                Delete...
                                            </a>
                                        </div>
                                    </div>
                                </td>
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
        .table td > input {
            min-width: 250px;
        }
    }

    .table > thead > tr > td {
        position: relative;
    }

    .table > thead > tr > td > div.float-right > a,
    .table > tbody > tr > td > div.dropdown > a {
        font-size: 18px;
        padding: 5px 8px;
    }
</style>
