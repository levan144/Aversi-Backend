<template>
    <div>
        <div class="flex items-center">
            <img :src="flagUrl" class="mr-2" width="20">
            <select v-model="selectedLanguage" @change="switchLanguage">
                <option v-for="language in languages" :key="language.key" :value="language.key">
                    {{ language.label }}
                </option>
            </select>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            languages: [
                { key: 'en', label: 'English', flag: 'us' },
                { key: 'fr', label: 'French', flag: 'fr' },
                // Add other languages here
            ],
            selectedLanguage: null,
        }
    },
    computed: {
        flagUrl() {
            return `https://flagcdn.com/${this.selectedLanguage}.svg`
        }
    },
    methods: {
        switchLanguage() {
            window.location.href = `/set-language/${this.selectedLanguage}`;
        }
    },
    created() {
        this.selectedLanguage = document.documentElement.lang;
    },
}
</script>
