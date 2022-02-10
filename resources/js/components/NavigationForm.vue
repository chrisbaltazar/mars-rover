<template>
    <div id="navigation-form">
        <div class="row">
            <div class="col-10 offset-1 offset-lg-3 col-lg-6 text-center">
                <form class="mb-3" @submit.prevent="submit">
                    <h3 class="mb-5">Mars Rover Mission Control</h3>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Surface width</label>
                                <input type="number" class="form-control" step="0.1" v-model="formData.width"
                                       value="0" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Surface height</label>
                                <input type="number" class="form-control" step="0.1" v-model="formData.height"
                                       value="200" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label class="form-label">Origin point X</label>
                                <input type="number" class="form-control" step="0.1" v-model="formData.originX"
                                       placeholder="x" required>
                            </div>
                            <div class="col-4">
                                <label class="form-label">Origin point Y</label>
                                <input type="number" class="form-control" step="0.1" v-model="formData.originY"
                                       placeholder="y" required>
                            </div>
                            <div class="col-4">
                                <label class="form-label">Oriertation</label>
                                <select class="form-control" v-model="formData.orientation" required>
                                    <option value="N">NORTH</option>
                                    <option value="S">SOUTH</option>
                                    <option value="E">EAST</option>
                                    <option value="W">WEST</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Instructions</label>
                        <input type="text" class="form-control" v-model="formData.instructions" placeholder="navigation"
                               required>
                    </div>
                    <button class="btn btn-success btn-lg" :disabled="loading">Send commands</button>
                </form>

                <div class="alert alert-primary" v-if="missionReport">
                    {{missionReport}}
                </div>
                <div class="alert alert-danger" v-if="errorMessage">
                    {{errorMessage}}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            formData: {width: 200, height: 200},
            missionReport: '',
            errorMessage: '',
            loading: false
        }
    },
    methods: {
        async submit() {
            this.missionReport = ''
            this.errorMessage = ''
            try {
                this.loading = true
                const response = await axios.post('/api/navigate', this.formData)
                this.missionReport = response.data
            } catch (error) {
                console.log(error.response)
                let msg = []
                if (error.response.data.errors) {
                    _.toArray(error.response.data.errors).forEach(e => msg.push(e))
                    msg = msg.join(',')
                }else if(error.response.data) {
                    msg = error.response.data
                }else {
                    msg = 'Unknown error'
                }
                this.errorMessage = msg
            }
            this.loading = false
        },
    },
    mounted() {
        console.log('navigation')
    }
}
</script>
