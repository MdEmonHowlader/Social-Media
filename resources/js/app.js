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

// Follow System Component
window.followSystem = function (
    username,
    initialFollowing,
    initialFollowersCount
) {
    return {
        isFollowing: initialFollowing,
        followersCount: initialFollowersCount,
        isLoading: false,

        async toggleFollow() {
            if (this.isLoading) return;

            this.isLoading = true;
            const originalFollowing = this.isFollowing;
            const originalCount = this.followersCount;

            // Optimistically update UI
            this.isFollowing = !this.isFollowing;
            this.followersCount = this.isFollowing
                ? this.followersCount + 1
                : this.followersCount - 1;

            try {
                let response;
                if (originalFollowing) {
                    // Unfollow
                    response = await axios.delete(`/@${username}/unfollow`, {
                        headers: {
                            "X-Requested-With": "XMLHttpRequest",
                            Accept: "application/json",
                        },
                    });
                } else {
                    // Follow
                    response = await axios.post(
                        `/@${username}/follow`,
                        {},
                        {
                            headers: {
                                "X-Requested-With": "XMLHttpRequest",
                                Accept: "application/json",
                            },
                        }
                    );
                }

                // Update follower count from server response if available
                if (
                    response.data &&
                    response.data.followers_count !== undefined
                ) {
                    this.followersCount = response.data.followers_count;
                }

                // Update all follower counts on the page
                document
                    .querySelectorAll("[data-followers-count]")
                    .forEach((el) => {
                        el.textContent = this.followersCount;
                    });
            } catch (error) {
                console.error("Error toggling follow:", error);
                // Revert optimistic update on error
                this.isFollowing = originalFollowing;
                this.followersCount = originalCount;

                // Show error message
                if (error.response && error.response.status === 419) {
                    alert(
                        "Session expired. Please refresh the page and try again."
                    );
                } else {
                    alert("Something went wrong. Please try again.");
                }
            } finally {
                this.isLoading = false;
            }
        },
    };
};

Alpine.start();
