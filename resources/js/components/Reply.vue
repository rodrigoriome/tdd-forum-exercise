<script>
export default {
  props: ["attributes"],
  data() {
    return {
      editing: false,
      body: this.attributes.body,
      deleted: false
    };
  },
  methods: {
    update() {
      axios
        .patch(`/replies/${this.attributes.id}`, {
          body: this.body
        })
        .then(response => {
          this.editing = false;
          flash("Reply updated.");
        });
    },
    destroy() {
      axios.delete(`/replies/${this.attributes.id}`).then(({ data }) => {
        this.deleted = true;
        flash(data.status);
      });
    }
  }
};
</script>
