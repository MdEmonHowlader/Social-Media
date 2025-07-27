import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

// Comment System Component
window.commentSystem = function (postId, initialCount) {
    return {
        showComments: false,
        commentsCount: initialCount,
        newComment: "",
        comments: [],
        isLoading: false,

        toggle() {
            console.log("Toggle clicked");
            this.showComments = !this.showComments;
            if (this.showComments && this.comments.length === 0) {
                this.loadComments();
            }
        },

        loadComments() {
            // Load comments via AJAX
            axios
                .get(`/posts/${postId}/comments`)
                .then((response) => {
                    this.comments = response.data.comments;
                })
                .catch((error) => {
                    console.error("Error loading comments:", error);
                });
        },

        submitComment() {
            if (!this.newComment.trim()) return;

            this.isLoading = true;
            axios
                .post(`/posts/${postId}/comments`, {
                    content: this.newComment,
                })
                .then((response) => {
                    this.comments.unshift(response.data.comment);
                    this.commentsCount = response.data.total_comments;
                    this.newComment = "";
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert("Failed to add comment. Please try again.");
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },

        deleteComment(commentId) {
            if (!confirm("Are you sure you want to delete this comment?"))
                return;

            axios
                .delete(`/comments/${commentId}`)
                .then((response) => {
                    this.comments = this.comments.filter(
                        (c) => c.id !== commentId
                    );
                    this.commentsCount = response.data.total_comments;
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert("Failed to delete comment. Please try again.");
                });
        },
    };
};

Alpine.start();
