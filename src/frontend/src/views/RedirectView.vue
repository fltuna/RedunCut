<template>
        <div class="redirect">
                <h1>Redirecting...</h1>
                <p>Short code: {{ $route.params.shortCode }}</p>
        </div>
        <div v-if="error" class="error">
            <h1>Error occurred!</h1>
            <p>{{ error }}</p>
        </div>
</template>

<script>
export default {
    name: 'RedirectView',
    data() {
        return {
            shortCode: this.$route.params.shortCode,
            loading: true,
            error: null
        }
    },
    created() {
        console.log('Redirecting to:', this.shortCode)
        
        fetch(`/api/v1/redirect/${this.shortCode}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('URL Not Found')
                }
                return response.json()
            })
            .then(data => {
                if (data.original_url) {
                    window.location.href = data.original_url
                } else {
                    this.error = 'Redirect destination not found'
                    this.loading = false
                }
            })
            .catch(err => {
                this.error = err.message
                this.loading = false
            })
    }
}
</script>

<style scoped>
.redirect-page {
    text-align: center;
    padding: 40px;
}

.error {
    color: #d32f2f;
    margin-top: 20px;
}
</style>