@props(['milestones'])

{{--
    This is a reusable Blade component for a dynamic, horizontal timeline.
    It receives milestone data via a 'milestones' prop and handles all interactivity using Alpine.js.
--}}

<div
    x-data="{
        // Initialize component state from the Blade prop.
        // json_encode is used to safely pass the PHP array to JavaScript.
        milestones: {{ json_encode($milestones) }},
        activeIndex: 0,
        positionsReady: false, // New flag

        // Function to scroll the timeline smoothly to the active item.
        scrollTimeline() {
            const container = this.$refs.timelineContainer;
            // Filter for actual milestone elements, excluding the line segments
            const milestoneElements = Array.from(this.$refs.timeline.children).filter(el => el.classList.contains('milestone-item'));
            const activeElement = milestoneElements[this.activeIndex];
            if (activeElement) {
                const containerWidth = container.offsetWidth;
                const elementWidth = activeElement.offsetWidth;
                const elementLeft = activeElement.offsetLeft;

                // Calculate the scroll position to center the active item.
                let scrollPosition = elementLeft - (containerWidth / 2) + (elementWidth / 2);
                container.scrollTo({ left: scrollPosition, behavior: 'smooth' });
            }
        },

        // Set up a watcher to react when activeIndex changes.
        init() {
            this.$watch('activeIndex', () => this.scrollTimeline());
            // Initial scroll to center the first item.
            this.scrollTimeline();
            this.updateMilestonePositions(); // Call on init
            window.addEventListener('resize', this.updateMilestonePositions.bind(this)); // Call on resize
        },
        // Function to format date to YYYY年MM月
        formatDate(dateString) {
        const date = new Date(dateString);
        const year = date.getFullYear();
        const month = (date.getMonth() +
        1).toString().padStart(2, '0'); // getMonth() 是 0-indexed
        return `${year}/${month}`;
        },
        // Function to calculate spacing based on date difference
        spacing(index) {
            if (index === 0) {
                return '2rem'; // Default left padding for the first item
            }
            const prevDate = new Date(this.milestones[index - 1].date);
            const currDate = new Date(this.milestones[index].date);
            // Calculate difference in months
            const diffYear = currDate.getFullYear() - prevDate.getFullYear();
            const diffMonth = diffYear * 12 + currDate.getMonth() - prevDate.getMonth();
            // Define base and multiplier for spacing (in rem)
            const baseRem = 2;
            const monthMultiplier = 0.5;
            let newSpacing = baseRem + (diffMonth * monthMultiplier);
            // Clamp the spacing to a min/max range
            newSpacing = Math.max(2, Math.min(24, newSpacing));
            return `${newSpacing}rem`;
        },
        // Function to store element positions
        updateMilestonePositions() {
            this.$nextTick(() => {
                const milestoneElements = Array.from(this.$refs.timeline.children).filter(el => el.classList.contains('milestone-item'));
                milestoneElements.forEach((el, index) => {
                    this.milestones[index].offsetLeft = el.offsetLeft;
                    this.milestones[index].offsetWidth = el.offsetWidth;
                });
                this.positionsReady = true; // Set flag after positions are ready
            });
        },
        }"
    x-init="init()"
    class="w-full max-w-5xl mx-auto py-12 font-sans"
>
    <!-- 1. Timeline Display Area (now includes buttons) -->
    <div class="relative">
        <!-- Navigation Buttons (now absolutely positioned) -->
        <button
            @click="activeIndex = Math.max(0, activeIndex - 1)"
            :disabled="activeIndex === 0"
            class="absolute left-0 top-[38%] -translate-y-1/2 p-2 rounded-full bg-[#0d256d] border border-white shadow-md disabled:opacity-50 disabled:cursor-not-allowed z-20 hover:bg-white/20"
        >
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>

        <div x-ref="timelineContainer" class="overflow-x-auto pb-8 scrollbar-hide">
            <div x-ref="timeline" class="inline-flex items-start justify-start pl-8 pr-16" style="min-width: 100%;">
                <template x-for="(milestone, index) in milestones" :key="index">
                    <div
                        @click="activeIndex = index"
                        class="relative flex flex-col items-center cursor-pointer group pr-16 milestone-item"
                        :style="`flex: 0 0 auto; padding-left: ${spacing(index)}`"
                    >
                        <div
                            class="text-sm font-semibold transition-colors duration-300"
                            :class="activeIndex === index ? 'text-indigo-500' : 'text-white group-hover:text-gray-800'"
                            x-text="formatDate(milestone.date)"
                        ></div>
                        <div
                            class="w-4 h-4 mt-2 rounded-full transition-all duration-300 z-10"
                            :class="activeIndex === index ? 'bg-indigo-600' : 'bg-white'"
                        ></div>
                        <div
                            class="mt-2 text-xs text-center font-medium transition-colors duration-300"
                            :class="activeIndex === index ? 'text-indigo-600' : 'text-white group-hover:text-gray-600'"
                            x-text="milestone.title"
                        ></div>
                    </div>
                </template>
            </div>
        </div>
        <div class="absolute top-[38px] left-1/2 -translate-x-1/2 w-11/12 h-1 bg-white"></div>

        <button
            @click="activeIndex = Math.min(milestones.length - 1, activeIndex + 1)"
            :disabled="activeIndex === milestones.length - 1"
            class="absolute right-0 top-[38%] -translate-y-1/2 p-2 rounded-full bg-[#0d256d] border border-white shadow-md disabled:opacity-50 disabled:cursor-not-allowed z-20 hover:bg-white/20"
        >
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </div>

    <!-- 2. Details Display Area -->
    <div class="relative w-full h-32 mt-8 text-center">
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
                <h3 class="text-2xl font-bold text-white" x-text="milestone.title"></h3>
                <p class="mt-2 text-indigo-600" x-text="milestone.date"></p>
                <p class="mt-2 text-white" x-text="milestone.description"></p>
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
