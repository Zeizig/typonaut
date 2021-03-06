<template>
    <div class="half-screen pt-5" :class="[ side ]">

        <h1>{{ word }}</h1>

        <input type="text"
               class="form-control form-control-lg word-input animated"
               :class="{ shake: wrongWord, 'form-control-success': done }"
               :id="side === 'player' ? 'player-input' : ''"
               name="word-input"
               v-model="typed"
               :disabled="side === 'opponent' || done"
               :ref="side === 'player' ? 'player-input' : ''"
               @keyup="handleTyped"
               @keydown.enter="onEnterPressed">

    </div>
</template>

<script>
    export default {

        props: {
            side: { required: true },
            round: { required: true },
            typed_word: { required: false, default: '' },
            show_word: { required: true },
        },

        data() {
            return {
                typed: '',
                wrongWord: false,
                done: false,
            }
        },

        watch: {
            typed_word() {
                this.typed = this.typed_word
            },
        },

        computed: {
            word() {
                return this.show_word ? this.round.word : ''
            }
        },

        methods: {
            onEnterPressed(e) {
                if (this.round.word !== this.typed) {
                    // Incorrect word
                    this.wrongWord = true
                    setTimeout( () => {
                        this.wrongWord = false
                    }, 1000)
                    return
                }

                this.$emit('answer-was-submitted', this.typed)
                this.done = true
            },

            handleTyped(e) {
                this.$emit('typed', this.typed)
            }
        },

        mounted() {
            if (this.typed_word.length > 0) {
                this.typed = this.typed_word
            }

            window.Events.$on('new-round', () => {
                this.typed = ''
                this.done = true
            })
            window.Events.$on('new-round-start-typing', () => {
                this.done = false
                if (this.side === 'player') {
                    setTimeout(() => {
                        this.$refs['player-input'].focus()
                    }, 100)
                }
            })
        },
    }
</script>

<style lang="scss" scoped>

    .half-screen {
        height: 100vh;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;

        &.player {
            background-color: #0a0a0a;
            color: #fdfcfc;
        }

        &.opponent {
            background-color: #fdfcfc;
            color: #0a0a0a;
        }

        h1 {
            flex: 0.35;
        }
    }

    .word-input {
        width: 75%;

        &:focus {
            border-color: #48d1cc;
        }
    }

    .time-container {
        text-align: center;
    }

    .animated {
        animation-duration: 1s;
        animation-fill-mode: both;
    }

    @keyframes shake {
        from, to {
            transform: translate3d(0, 0, 0);
        }

        10%, 30%, 50%, 70%, 90% {
            transform: translate3d(-7px, 0, 0);
        }

        20%, 40%, 60%, 80% {
            transform: translate3d(7px, 0, 0);
        }
    }

    .shake {
        animation-name: shake;
    }

    .word-input.shake:focus {
        border-color: #d9534f;
    }

    .form-control-success {
        border-color: #5cb85c;
    }

</style>
