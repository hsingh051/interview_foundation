<template>
    <div>
        <div>
            <label><strong>Your github access token:</strong> {{token}}</label>
            <b-button @click="deleteToken()" class="float-right" variant="danger"><b-icon icon="trash"></b-icon></b-button>
        </div>
        <div class="text-center mt-3">
            <b-button variant="outline-primary" @click="getRepositories()">Get GitHub Repositories</b-button>
            <div v-if="isLoading" class="mt-4">
                Getting your data <b-icon icon="arrow-clockwise" animation="spin" font-scale="1"></b-icon>
            </div>
            <div v-if="userRepositories" class="mt-4">
                <b-table striped hover :items="userRepositories" :fields="fields"></b-table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        token: {
            type: String,
            required: true
        },
        endpoint: {
            type: String,
            required: true
        },
        deleteEndpoint: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            form: {
                githubToken: null,
            },
            isLoading: false,
            userRepositories: null,
            fields: ['id', 'name', 'created_at', 'updated_at'],
        }
    },
    methods: {
        getRepositories() {
            this.isLoading = true
            var that = this;
            axios.post(this.endpoint)
                .then(response => {
                    this.isLoading = false
                    this.userRepositories = response.data.data.repositories;
                    console.log(response)
                })
                .catch(function(error) {
                    that.isLoading = false;
                    that.makeToast(error.response.data.message, 'danger');
                })
        },
        deleteToken() {
            var that = this;
            this.$bvModal.msgBoxConfirm('Are you sure?')
                .then(value => {
                    if(value){
                        axios.post(this.deleteEndpoint, {'githubToken': null})
                            .then(response => {
                                window.location.reload();
                            })
                            .catch(function(error) {
                                that.makeToast(error.response.data.message, 'danger');
                            })
                    }
                })
        },
        makeToast(message, variant = null) {
            this.$bvToast.toast(message, {
                title: 'Error:',
                variant: variant,
                solid: true
            })
        },
    }
}
</script>
