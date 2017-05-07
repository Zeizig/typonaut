<template>

    <div class="game-score-container">
        <div class="card dark-card">
            <div class="card-block">
                <div class="overview-container">
                    <div class="scores">{{ score }}</div>
                    <div class="winner-text">{{ winner }}</div>
                </div>
                <hr>
                <table class="rounds-table">
                    <thead>
                        <tr class="header">
                            <td class="word">Word</td>
                            <td class="player-time">Player 1 time</td>
                            <td class="player-time">Player 2 time</td>
                            <td class="winner">Result</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="round in completed_rounds">
                            <td class="word">{{ round.word }}</td>
                            <td class="player-time">{{ round.player_one_time }}</td>
                            <td class="player-time">{{ round.player_two_time }}</td>
                            <td class="winner">{{ winner }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</template>

<script>

    export default {
        props: {
            completed_rounds: { required: true },
            game: { required: true },
        },

        data() {
            return {

            }
        },

        computed: {

            score() {
                let scoreOne = 0
                let scoreTwo = 0
                this.completed_rounds.forEach( round => {
                    if (round.player_one_time < round.player_two_time) {
                        scoreOne++
                    } else {
                        scoreTwo++
                    }
                })
                return scoreOne + " - " + scoreTwo
            },

            winner() {
                let lastRound = this.completed_rounds[this.completed_rounds.length - 1]
                let playerOne = this.game.player_one_id
                let playerTwo = this.game.player_two_id
                let winner = lastRound.player_one_time < lastRound.player_two_time ? playerOne : playerTwo
                return window.Laravel.user.id == winner ? 'You won!' : 'You lost!'
            }
        }
    }
</script>

<style lang="scss" scoped>

    .game-score-container {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1050;
        display: flex;
        align-items: center;
        justify-content: center;

        background-color: rgba(0, 0, 0, 0.7);

        hr {
            border-top: 1px solid #fdfcfc;
        }
    }

    .overview-container {
        text-align: center;

        .scores {
            font-size: 60px;
        }

        .winner-text {
            font-size: 50px;
        }
    }

    .game-score-container .dark-card {
        border: 2px solid #fdfcfc;
        font-family: 'Noto Serif', serif;

        .card-block {
            padding: 1.5rem;
        }
    }

    .rounds-table {
        padding: 0;
        font-size: 1.1rem;

        .header td {
            padding-bottom: 10px;
        }

        td {
            padding: 0px 10px;
            text-align: center;
        }
    }
</style>