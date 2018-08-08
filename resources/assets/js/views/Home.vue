<template>
    <div v-if="loading" class="loading text-center">
        <i class="fas fa-circle-notch fa-spin"></i>
    </div>

    <div class="container pt-4 pb-4" v-else>
        <table class="table table-striped table-responsive-sm">
            <thead>
                <tr>
                    <td>
                        Full Name
                    </td>

                    <td>
                        Email Address
                    </td>

                    <td>
                        Phone Number
                    </td>
                </tr>
            </thead>

            <tbody>
                <template v-for="person in people">
                    <tr>
                        <td v-text="person.name"></td>

                        <td v-text="person.email"></td>

                        <td v-text="person.phone"></td>
                    </tr>
                </template>
            </tbody>
        </table>

        <nav>
            <paginate
                    v-model="pageNumber"
                    :page-count="meta.last_page"
                    :page-range="3"
                    :margin-pages="2"
                    :click-handler="getPaginatedResults"
                    :prev-text="'Prev'"
                    :next-text="'Next'"
                    container-class="pagination justify-content-center mt-4"
                    page-class="page-item"
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
                pageNumber: 1,

                loading: true,
                refreshing: false,
            };
        },

        methods: {
            getPeople() {
                axios.get('/api/people?page=' + this.pageNumber).then(HttpResponse => {
                    let data = HttpResponse.data;

                    this.people = data.data;
                    this.meta = data.meta;

                    this.loading = false;
                    this.refreshing = false;

                    console.log(data);
                });
            },

            getPaginatedResults() {
                this.refreshing = true;

                this.getPeople();
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
