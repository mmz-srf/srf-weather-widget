<script>
  export let rainInMM;

  $: isDarkMode = window.matchMedia("(prefers-color-scheme: dark)").matches;
</script>

<div class="h-[30px] w-full flex flex-col-reverse items-center relative mt-2">
  <div
    class="absolute w-full h-full"
    style={isDarkMode
      ? `background: linear-gradient(180deg, rgba(0, 64, 114, 1), rgba(0, 64, 114, 1) 1px, transparent 1%, transparent); background-size: 100% 5px;`
      : `background: linear-gradient(180deg, rgba(11, 95, 161, 1), rgba(11, 95, 161, 1) 1px, transparent 1%, transparent); background-size: 100% 5px;`}
  />
  <div
    class="bg-sky-500 w-1/2 max-h-8 absolute bottom-[4px]"
    style={`height: ${rainInMM * 2.5}px;`}
  />
</div>
