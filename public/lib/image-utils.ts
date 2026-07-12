const API_BASE_URL = process.env.NEXT_PUBLIC_API_URL || "http://localhost:8000";

export function getImageUrl(imagePath: string | null | undefined): string {
  if (!imagePath) {
    return "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='300'%3E%3Crect width='400' height='300' fill='%23f3f4f6'/%3E%3Ctext x='50%25' y='50%25' dominant-baseline='middle' text-anchor='middle' font-family='sans-serif' font-size='18' fill='%239ca3af'%3ENo Image%3C/text%3E%3C/svg%3E";
  }

  // If already an absolute URL, return as is
  if (imagePath.startsWith("http://") || imagePath.startsWith("https://")) {
    return imagePath;
  }

  // If starts with /, it's already a public path
  if (imagePath.startsWith("/")) {
    return imagePath;
  }

  // Otherwise, prepend the API storage URL
  return `${API_BASE_URL}/storage/${imagePath}`;
}
