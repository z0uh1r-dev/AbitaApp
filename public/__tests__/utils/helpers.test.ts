/**
 * Helper Functions Tests
 *
 * Unit tests for utility helper functions.
 */

import {
  formatCurrency,
  formatDate,
  truncate,
  slugify,
  isEmpty,
  capitalize,
  generateId,
} from "@/utils/helpers";

describe("Helper Functions", () => {
  describe("formatCurrency", () => {
    it("should format number as MAD currency", () => {
      expect(formatCurrency(1234.56)).toContain("MAD");
      expect(formatCurrency(1000)).toContain("1");
    });
  });

  describe("formatDate", () => {
    it("should format date to readable string", () => {
      const date = new Date("2026-03-06");
      const formatted = formatDate(date);
      expect(formatted).toContain("2026");
    });
  });

  describe("truncate", () => {
    it("should truncate long text with ellipsis", () => {
      expect(truncate("This is a long text", 10)).toBe("This is a...");
    });

    it("should not truncate short text", () => {
      expect(truncate("Short", 10)).toBe("Short");
    });

    it("should handle exact length", () => {
      expect(truncate("Exactly10!", 10)).toBe("Exactly10!");
    });
  });

  describe("slugify", () => {
    it("should convert text to slug", () => {
      expect(slugify("Hello World!")).toBe("hello-world");
    });

    it("should handle special characters", () => {
      expect(slugify("Test@#$%123")).toBe("test123");
    });

    it("should handle multiple spaces", () => {
      expect(slugify("Too   Many    Spaces")).toBe("too-many-spaces");
    });
  });

  describe("isEmpty", () => {
    it("should return true for null and undefined", () => {
      expect(isEmpty(null)).toBe(true);
      expect(isEmpty(undefined)).toBe(true);
    });

    it("should return true for empty string", () => {
      expect(isEmpty("")).toBe(true);
      expect(isEmpty("   ")).toBe(true);
    });

    it("should return true for empty array", () => {
      expect(isEmpty([])).toBe(true);
    });

    it("should return true for empty object", () => {
      expect(isEmpty({})).toBe(true);
    });

    it("should return false for non-empty values", () => {
      expect(isEmpty("text")).toBe(false);
      expect(isEmpty([1])).toBe(false);
      expect(isEmpty({ a: 1 })).toBe(false);
    });
  });

  describe("capitalize", () => {
    it("should capitalize first letter", () => {
      expect(capitalize("hello")).toBe("Hello");
    });

    it("should handle already capitalized", () => {
      expect(capitalize("Hello")).toBe("Hello");
    });

    it("should handle empty string", () => {
      expect(capitalize("")).toBe("");
    });
  });

  describe("generateId", () => {
    it("should generate a random ID", () => {
      const id1 = generateId();
      const id2 = generateId();
      expect(id1).toHaveLength(8);
      expect(id1).not.toBe(id2);
    });
  });
});
