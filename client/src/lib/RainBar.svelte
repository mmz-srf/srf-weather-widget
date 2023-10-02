<script>
  export let rainInMM;

  let useDarkMode = window.matchMedia("(prefers-color-scheme: dark)").matches;
  $: useDarkMode;
</script>

<div class="h-[30px] w-full flex flex-col-reverse items-center relative mt-2">
  <div
    class="absolute w-full h-full"
    style={useDarkMode
      ? `background: linear-gradient(180deg, rgb(8, 81, 139), rgb(8, 81, 139) 1px, transparent 1%, transparent); background-size: 100% 5px;`
      : `background: linear-gradient(180deg, rgba(0, 64, 114, 1), rgba(0, 64, 114, 1) 1px, transparent 1%, transparent); background-size: 100% 5px;`}
  />
  <div
    class="bg-sky-500 w-1/2 max-h-8 absolute bottom-[4px]"
    style={`height: ${rainInMM * 2.5}px;`}
  />
</div>
