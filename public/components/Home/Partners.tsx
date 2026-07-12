export default function Partners() {
  return (
    <section className="py-20 bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16">
          <h2 className="text-4xl md:text-5xl font-bold mb-4">
            Ils nous font confiance
          </h2>
          <p className="text-xl text-gray-600">
            La confiance des entreprises et institutions
          </p>
        </div>

        <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
          <div className="bg-gray-50 rounded-3xl p-8 flex items-center justify-center border-2 border-gray-200 transition-all hover:border-primary">
            <div className="w-24 h-24 bg-gray-200 rounded-2xl flex items-center justify-center">
              <span className="text-gray-400 text-sm font-medium">
                Company A
              </span>
            </div>
          </div>
          <div className="bg-gray-50 rounded-3xl p-8 flex items-center justify-center border-2 border-gray-200 transition-all hover:border-primary">
            <div className="w-24 h-24 bg-gray-200 rounded-2xl flex items-center justify-center">
              <span className="text-gray-400 text-sm font-medium">
                Company B
              </span>
            </div>
          </div>
          <div className="bg-gray-50 rounded-3xl p-8 flex items-center justify-center border-2 border-gray-200 transition-all hover:border-primary">
            <div className="w-24 h-24 bg-gray-200 rounded-2xl flex items-center justify-center">
              <span className="text-gray-400 text-sm font-medium">
                Company C
              </span>
            </div>
          </div>
          <div className="bg-gray-50 rounded-3xl p-8 flex items-center justify-center border-2 border-gray-200 transition-all hover:border-primary">
            <div className="w-24 h-24 bg-gray-200 rounded-2xl flex items-center justify-center">
              <span className="text-gray-400 text-sm font-medium">
                Company D
              </span>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
