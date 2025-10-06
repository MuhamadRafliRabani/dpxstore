const SkeletonGameCard = () => (
  <div className="games animate-pulse bg-muted relative translate-y-8 overflow-hidden rounded-2xl">
    <div className="aspect-[4/6] w-full rounded-2xl bg-gray-300" />
    <div className="absolute inset-0 flex flex-col justify-end p-3">
      <div className="space-y-1">
        <div className="h-4 w-3/4 rounded bg-gray-400" />
        <div className="h-3 w-1/2 rounded bg-gray-400" />
      </div>
    </div>
  </div>
);

export default SkeletonGameCard