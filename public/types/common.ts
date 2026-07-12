/**
 * Common Utility Types
 */

export type Maybe<T> = T | null | undefined;

export type Nullable<T> = T | null;

export type Optional<T> = T | undefined;

export interface PageProps<T = Record<string, string | string[] | undefined>> {
  params: Promise<T>;
  searchParams: Promise<Record<string, string | string[] | undefined>>;
}

export interface PageParams {
  slug: string;
}

export interface SearchParams {
  category?: string;
  page?: string;
  search?: string;
}
