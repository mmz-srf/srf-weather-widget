<script>
  export let rainInMM;
</script>

<div class="h-8 w-full flex flex-col-reverse items-center relative">
  <div
    class="absolute h-full w-full -bottom-px"
    style={`background: linear-gradient(180deg, rgba(11, 95, 161, 1), rgba(11, 95, 161, 1) 1px, transparent 1%, transparent); background-size: 100% 5px;`}
  />
  <div
    class="bg-sky-500 w-1/2 max-h-8 relative flex flex-col items-center"
    style={`height: ${rainInMM * 2.5}px;`}
  >
    <span class="absolute font-light">{rainInMM}</span>
  </div>
</div>
