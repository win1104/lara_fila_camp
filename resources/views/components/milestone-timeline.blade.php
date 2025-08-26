@props(['milestones'])

{{--
    This is a reusable Blade component for a dynamic, horizontal timeline.
    This version uses absolute positioning calculated in JavaScript for stability,
    based on the architecture of a working example.
--}}

<div
    x-data="{
        milestones: {{ json_encode($milestones) }},
        activeIndex: 0,
        totalTimelineWidth: 0,
        fillingLineScale: 0,

        // New architecture: calculate all positions in JS, do not measure the DOM.
        init() {
            // Add a left_px property to each milestone for its calculated position
            this.milestones.forEach(m => m.left_px = 0);

            this.calculatePositions();

            this.$watch('activeIndex', () => {
                this.scrollTimeline();
                this.updateFillingLine();
            });

            // Initial UI update after Alpine has initialized
            this.$nextTick(() => {
                this.scrollTimeline();
                this.updateFillingLine();
            });

            // Optional: Recalculate on resize if the container width is a factor
            // window.addEventListener('resize', () => this.calculatePositions());
        },

        calculatePositions() {
            const pixelsPerDay = 1.0; // Determines the timeline scale. Adjustable.
            const baseWidth = 150;    // The width of each milestone item in pixels. Adjustable.

            if (this.milestones.length < 2) {
                this.totalTimelineWidth = baseWidth;
                return;
            }

            const firstDate = new Date(this.milestones[0].date);

            // Calculate the left position for each milestone based on days from the start
            this.milestones.forEach((milestone) => {
                const currentDate = new Date(milestone.date);
                const diffTime = Math.abs(currentDate - firstDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                milestone.left_px = diffDays * pixelsPerDay;
            });

            // Set the total width of the timeline based on the last milestone's position
            const lastMilestone = this.milestones[this.milestones.length - 1];
            this.totalTimelineWidth = lastMilestone.left_px + baseWidth;
        },

        scrollTimeline() {
            const container = this.$refs.timelineContainer;
            const activeMilestone = this.milestones[this.activeIndex];
            if (!activeMilestone) return;

            const containerWidth = container.offsetWidth;
            const elementLeft = activeMilestone.left_px; // Use our calculated left position
            const elementWidth = 150; // Use our fixed base width

            let scrollPosition = elementLeft - (containerWidth / 2) + (elementWidth / 2);
            container.scrollTo({ left: scrollPosition, behavior: 'smooth' });
        },

        updateFillingLine() {
            const activeMilestone = this.milestones[this.activeIndex];
            if (!activeMilestone || this.totalTimelineWidth === 0) {
                this.fillingLineScale = 0;
                return;
            }
            const elementWidth = 150; // Use our fixed base width
            const activeCenter = activeMilestone.left_px + (elementWidth / 2);
            this.fillingLineScale = activeCenter / this.totalTimelineWidth;
        },

        formatDate(dateString) {
            const date = new Date(dateString);
            const year = date.getFullYear();
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            return `${year}/${month}`;
        },
    }"
    x-init="init()"
    class="w-full mx-auto py-8 font-sans"
>
    <!-- 1. Timeline Display Area: Wrapped in a container with a specific max-width -->
    <div class="relative max-w-[934px] mx-auto">
        <!-- Navigation Buttons -->
        <button
            @click="activeIndex = Math.max(0, activeIndex - 1)"
            :disabled="activeIndex === 0"
            class="absolute left-0 top-[22%] -translate-y-1/2 p-2 rounded-full border border-white shadow-md disabled:opacity-50 disabled:cursor-not-allowed z-20"
        >
            <svg class="w-6 h-6 text-red-500" :class="{ 'opacity-0': activeIndex === 0 }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>

        <!-- Main container now inherits the max-width and provides the scroll functionality -->
        <div x-ref="timelineContainer" class="relative overflow-x-auto pb-8 scrollbar-hide mx-12" style="height: 150px;">
            <!-- The timeline track has its width set dynamically from JS and is allowed to overflow -->
            <div x-ref="timeline" class="relative" :style="`height: 100%; width: ${totalTimelineWidth}px;`">

                <!-- Timeline Track -->
                <div class="absolute top-[30px] left-0 w-full h-1 bg-gray-300/50 z-0"></div>
                <!-- Colored Progress Line -->
                <div
                    class="absolute top-[30px] left-0 w-full h-1 bg-red-700 origin-left transition-transform duration-300 ease-out z-0"
                    :style="`transform: scaleX(${fillingLineScale})`"
                ></div>

                <template x-for="(milestone, index) in milestones" :key="index">
                    <!-- Milestone items are absolutely positioned within the track -->
                    <div
                        @click="activeIndex = index"
                        class="absolute top-0 flex flex-col items-center cursor-pointer group w-[150px]"
                        :style="`left: ${milestone.left_px}px`"
                    >
                        <div
                            class="text-base font-semibold transition-colors duration-300 text-white"
                            {{-- :class="activeIndex === index ? 'text-white' : 'text-white group-hover:text-gray-800'" --}}
                            x-text="formatDate(milestone.date)"
                        ></div>
                        <div
                            class="w-4 h-4 rounded-full transition-all duration-300 z-10"
                            :class="{ 'bg-red-700': activeIndex === index, 'bg-white': activeIndex !== index, 'border-red-700 border-4': activeIndex > index }"
                        ></div>
                        {{-- <div
                            class="mt-2 text-xs text-center font-medium transition-colors duration-300"
                            :class="activeIndex === index ? 'text-indigo-600' : 'text-white group-hover:text-gray-600'"
                            x-text="milestone.title"
                        ></div> --}}
                    </div>
                </template>
            </div>
        </div>

        <button
            @click="activeIndex = Math.min(milestones.length - 1, activeIndex + 1)"
            :disabled="activeIndex === milestones.length - 1"
            class="absolute right-0 top-[22%] -translate-y-1/2 p-2 rounded-full border border-white shadow-md disabled:opacity-50 disabled:cursor-not-allowed z-20 hover:bg-white/20"
        >
            <svg class="w-6 h-6 text-red-500" :class="{ 'opacity-0': activeIndex === milestones.length - 1 }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </div>

    <!-- 2. Details Display Area -->
    <div class="relative w-full h-32 text-center max-w-[934px] mx-auto">
        <template x-for="(milestone, index) in milestones" :key="index">
            <div
                x-show="activeIndex === index"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200 absolute"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform -translate-y-4"
                class="absolute inset-0 w-full"
            >
                <h3 class="text-5xl font-bold text-white mb-8" x-text="milestone.title"></h3>
                <p class="mt-2 text-red-700 text-xl mb-4" x-text="milestone.date"></p>
                <p class="mt-2 text-white text-xl" x-text="milestone.description"></p>
            </div>
        </template>
    </div>

</div>

<style>
    /* Utility to hide the scrollbar but keep the scrolling functionality */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>
