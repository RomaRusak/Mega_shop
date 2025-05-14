<template>
    <teleport to="body">
      <div class="page-preloader-container">
          <h2 class="page-preloader">Loading</h2>
      </div>
    </teleport>
  </template>

<script>
import { onMounted, onBeforeUnmount } from 'vue';

    export default {
        setup() {
            onMounted(() => {
                document.body.classList.add('stop-scroll');
            });

            onBeforeUnmount(() => {
                document.body.classList.remove('stop-scroll');
            });
    }
}
</script>

<style>
    @keyframes load {
    0%{
        opacity: 0.08;
/*         font-size: 10px; */
/* 				font-weight: 400; */
				filter: blur(5px);
				letter-spacing: 3px;
        }
    100%{
/*         opacity: 1; */
/*         font-size: 12px; */
/* 				font-weight:600; */
/* 				filter: blur(0); */
        }
}

.stop-scroll {
    overflow: hidden;
}

.page-preloader{
	display:flex;
	justify-content: center;
	align-items: center;
	height:100%;
	margin: auto;
	font-size: 104px;
	font-family: Helvetica, sans-serif, Arial;
	animation: load 1.2s infinite 0s ease-in-out;
	animation-direction: alternate;
	text-shadow: 0 0 1px white;
}

.page-preloader-container {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: white;
	color: #3C4242;
    z-index: 9999;
}
</style>