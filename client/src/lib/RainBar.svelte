<script>
  export let rainInMM;
</script>

<div class="h-8 w-full flex flex-col-reverse items-center">
  <div
    class="bg-sky-500 w-1/2 max-h-8 relative flex flex-col items-center"
    style={`height: ${rainInMM * 2.5}px;`}
  >
    <span class="absolute font-light">{rainInMM}</span>
  </div>
</div>
