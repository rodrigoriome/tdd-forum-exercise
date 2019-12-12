<template>
    <button :class="classes" @click="toggle">{{ count }} {{ label }}</button>
</template>

<script>
export default {
    props: ["reply"],
    data() {
        return {
            count: this.reply.favoritesCount,
            isFavorited: this.reply.isFavorited,
            endpoint: `/replies/${this.reply.id}/favorites`
        };
    },
    computed: {
        classes() {
            return [
                "btn",
                this.isFavorited ? "btn-primary" : "btn-outline-primary"
            ];
        },
        label() {
            return this.count == 1 ? "Favorite" : "Favorites";
        }
    },
    methods: {
        toggle() {
            return this.isFavorited ? this.unfavorite() : this.favorite();
        },
        favorite() {
            axios.post(this.endpoint).then(() => {
                this.isFavorited = true;
                this.count++;
            });
        },
        unfavorite() {
            axios.delete(this.endpoint).then(() => {
                this.isFavorited = false;
                this.count--;
            });
        }
    }
};
</script>
