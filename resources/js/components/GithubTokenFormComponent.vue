<template>
    <div>
        <b-form @submit="onSubmit" @reset="onReset" v-if="show">
            <b-form-group id="input-token" label="Github Token:" label-for="token">
                <b-form-input
                    id="token"
                    v-model="form.githubToken"
                    placeholder="Enter Github Token"
                    required
                ></b-form-input>
            </b-form-group>

            <b-button type="submit" variant="primary">Submit</b-button>
            <b-button type="reset" variant="danger">Reset</b-button>
        </b-form>
    </div>
</template>

<script>
export default {
    props: {
        endpoint: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            form: {
                githubToken: null,
            },
            show: true
        }
    },
    methods: {
        onSubmit(event) {
            event.preventDefault()
            this.isLoading = true;

            axios.post(this.endpoint, this.form)
                .then(response => {
                    this.isLoading = false;
                    if (response.data.success == true){
                        window.location.reload();
                    }else{
                        this.makeToast('Something went wrong!', 'danger');
                    }
                })
        },
        onReset(event) {
            event.preventDefault()
            // Reset our form values
            this.form.github_token = ''
            // Trick to reset/clear native browser form validation state
            this.show = false
            this.$nextTick(() => {
                this.show = true
            })
        },
        makeToast(message, variant = null) {
            this.$bvToast.toast(message, {
                title: 'Error:',
                variant: variant,
                solid: true
            })
        }
    }
}
</script>
