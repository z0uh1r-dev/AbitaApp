export default function RootLoading() {
  return (
    <div className="min-h-screen flex items-center justify-center bg-white">
      <div className="flex flex-col items-center gap-4">
        <div className="h-12 w-12 rounded-full border-4 border-primary/20 border-t-primary animate-spin" />
        <p className="text-sm font-medium text-gray-700">
          Chargement de l&apos;expérience ABITA...
        </p>
      </div>
    </div>
  );
}
