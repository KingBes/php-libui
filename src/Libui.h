// option
typedef struct uiInitOptions uiInitOptions;
struct uiInitOptions
{
    unsigned long long Size;
};
const char *uiInit(uiInitOptions *options);
void uiUninit(void);
void uiFreeInitError(const char *err);
void uiMain(void);
void uiMainSteps(void);
int uiMainStep(int wait);
void uiQuit(void);
void uiQueueMain(void (*f)(void *data), void *data);
void uiTimer(int milliseconds, int (*f)(void *data), void *data);
void uiOnShouldQuit(int (*f)(void *data), void *data);
void uiFreeText(char *text);

// control
typedef struct uiControl uiControl;
struct uiControl
{
    unsigned int Signature;
    unsigned int OSSignature;
    unsigned int TypeSignature;
    void (*Destroy)(uiControl *);
    unsigned long long (*Handle)(uiControl *);
    uiControl *(*Parent)(uiControl *);
    void (*SetParent)(uiControl *, uiControl *);
    int (*Toplevel)(uiControl *);
    int (*Visible)(uiControl *);
    void (*Show)(uiControl *);
    void (*Hide)(uiControl *);
    int (*Enabled)(uiControl *);
    void (*Enable)(uiControl *);
    void (*Disable)(uiControl *);
};
void uiControlDestroy(uiControl *);
unsigned long long uiControlHandle(uiControl *);
uiControl *uiControlParent(uiControl *);
void uiControlSetParent(uiControl *, uiControl *);
int uiControlToplevel(uiControl *);
int uiControlVisible(uiControl *);
void uiControlShow(uiControl *);
void uiControlHide(uiControl *);
int uiControlEnabled(uiControl *);
void uiControlEnable(uiControl *);
void uiControlDisable(uiControl *);
uiControl *uiAllocControl(unsigned long long n, unsigned int OSsig, unsigned int typesig, const char *typenamestr);
void uiFreeControl(uiControl *);
void uiControlVerifySetParent(uiControl *, uiControl *);
int uiControlEnabledToUser(uiControl *);
void uiUserBugCannotSetParentOnToplevel(const char *type);

// window
typedef struct uiWindow uiWindow;
char *uiWindowTitle(uiWindow *w);
void uiWindowSetTitle(uiWindow *w, const char *title);
void uiWindowPosition(uiWindow *w, int *x, int *y);
void uiWindowSetPosition(uiWindow *w, int x, int y);
void uiWindowOnPositionChanged(uiWindow *w, void (*f)(uiWindow *sender, void *senderData), void *data);
void uiWindowContentSize(uiWindow *w, int *width, int *height);
void uiWindowSetContentSize(uiWindow *w, int width, int height);
int uiWindowFullscreen(uiWindow *w);
void uiWindowSetFullscreen(uiWindow *w, int fullscreen);
void uiWindowOnContentSizeChanged(uiWindow *w, void (*f)(uiWindow *, void *), void *data);
void uiWindowOnClosing(uiWindow *w, int (*f)(uiWindow *w, void *data), void *data);
void uiWindowOnFocusChanged(uiWindow *w, void (*f)(uiWindow *sender, void *senderData), void *data);
int uiWindowFocused(uiWindow *w);
int uiWindowBorderless(uiWindow *w);
void uiWindowSetBorderless(uiWindow *w, int borderless);
void uiWindowSetChild(uiWindow *w, uiControl *child);
int uiWindowMargined(uiWindow *w);
void uiWindowSetMargined(uiWindow *w, int margined);
int uiWindowResizeable(uiWindow *w);
void uiWindowSetResizeable(uiWindow *w, int resizeable);
uiWindow *uiNewWindow(const char *title, int width, int height, int hasMenubar);

const char *uiOpenFile(uiWindow *parent);
const char *uiSaveFile(uiWindow *parent);
void uiMsgBox(uiWindow *parent, const char *title, const char *description);
void uiMsgBoxError(uiWindow *parent, const char *title, const char *description);

// box
typedef struct uiBox uiBox;
void uiBoxAppend(uiBox *b, uiControl *child, int stretchy);
int uiBoxNumChildren(uiBox *b);
void uiBoxDelete(uiBox *b, int index);
int uiBoxPadded(uiBox *b);
void uiBoxSetPadded(uiBox *b, int padded);
uiBox *uiNewHorizontalBox(void);
uiBox *uiNewVerticalBox(void);

// button
typedef struct uiButton uiButton;
const char *uiButtonText(uiButton *b);
void uiButtonSetText(uiButton *b, const char *text);
void uiButtonOnClicked(uiButton *b, void (*f)(uiButton *b, void *data), void *data);
uiButton *uiNewButton(const char *text);

// Checkbox
typedef struct uiCheckbox uiCheckbox;
char *uiCheckboxText(uiCheckbox *c);
void uiCheckboxSetText(uiCheckbox *c, const char *text);
void uiCheckboxOnToggled(uiCheckbox *c, void (*f)(uiCheckbox *c, void *data), void *data);
int uiCheckboxChecked(uiCheckbox *c);
void uiCheckboxSetChecked(uiCheckbox *c, int checked);
uiCheckbox *uiNewCheckbox(const char *text);

// Entry
typedef struct uiEntry uiEntry;
const char *uiEntryText(uiEntry *e);
void uiEntrySetText(uiEntry *e, const char *text);
void uiEntryOnChanged(uiEntry *e, void (*f)(uiEntry *e, void *data), void *data);
int uiEntryReadOnly(uiEntry *e);
void uiEntrySetReadOnly(uiEntry *e, int readonly);
uiEntry *uiNewEntry(void);
uiEntry *uiNewPasswordEntry(void);
uiEntry *uiNewSearchEntry(void);

// Label
typedef struct uiLabel uiLabel;
const char *uiLabelText(uiLabel *l);
void uiLabelSetText(uiLabel *l, const char *text);
uiLabel *uiNewLabel(const char *text);

// Tab
typedef struct uiTab uiTab;
int uiTabSelected(uiTab *t);
void uiTabSetSelected(uiTab *t, int index);
void uiTabOnSelected(uiTab *t, void (*f)(uiTab *sender, void *senderData), void *data);
void uiTabAppend(uiTab *t, const char *name, uiControl *c);
void uiTabInsertAt(uiTab *t, const char *name, int before, uiControl *c);
void uiTabDelete(uiTab *t, int index);
int uiTabNumPages(uiTab *t);
int uiTabMargined(uiTab *t, int page);
void uiTabSetMargined(uiTab *t, int page, int margined);
uiTab *uiNewTab(void);

// Group
typedef struct uiGroup uiGroup;
const char *uiGroupTitle(uiGroup *g);
void uiGroupSetTitle(uiGroup *g, const char *title);
void uiGroupSetChild(uiGroup *g, uiControl *c);
int uiGroupMargined(uiGroup *g);
void uiGroupSetMargined(uiGroup *g, int margined);
uiGroup *uiNewGroup(const char *title);

// Spinbox
typedef struct uiSpinbox uiSpinbox;
int uiSpinboxValue(uiSpinbox *s);
void uiSpinboxSetValue(uiSpinbox *s, int value);
void uiSpinboxOnChanged(uiSpinbox *s, void (*f)(uiSpinbox *s, void *data), void *data);
uiSpinbox *uiNewSpinbox(int min, int max);

// Slider
typedef struct uiSlider uiSlider;
int uiSliderValue(uiSlider *s);
void uiSliderSetValue(uiSlider *s, int value);
int uiSliderHasToolTip(uiSlider *s);
void uiSliderSetHasToolTip(uiSlider *s, int hasToolTip);
void uiSliderOnChanged(uiSlider *s, void (*f)(uiSlider *s, void *data), void *data);
void uiSliderOnReleased(uiSlider *s, void (*f)(uiSlider *sender, void *senderData), void *data);
void uiSliderSetRange(uiSlider *s, int min, int max);
uiSlider *uiNewSlider(int min, int max);

// ProgressBar
typedef struct uiProgressBar uiProgressBar;
int uiProgressBarValue(uiProgressBar *p);
void uiProgressBarSetValue(uiProgressBar *p, int n);
uiProgressBar *uiNewProgressBar(void);

// Separator
typedef struct uiSeparator uiSeparator;
uiSeparator *uiNewHorizontalSeparator(void);
uiSeparator *uiNewVerticalSeparator(void);

// Combobox
typedef struct uiCombobox uiCombobox;
void uiComboboxAppend(uiCombobox *c, const char *text);
void uiComboboxInsertAt(uiCombobox *c, int index, const char *text);
void uiComboboxDelete(uiCombobox *c, int index);
void uiComboboxClear(uiCombobox *c);
int uiComboboxNumItems(uiCombobox *c);
int uiComboboxSelected(uiCombobox *c);
void uiComboboxSetSelected(uiCombobox *c, int n);
void uiComboboxOnSelected(uiCombobox *c, void (*f)(uiCombobox *c, void *data), void *data);
uiCombobox *uiNewCombobox(void);

// EditableCombobox
typedef struct uiEditableCombobox uiEditableCombobox;
void uiEditableComboboxAppend(uiEditableCombobox *c, const char *text);
const char *uiEditableComboboxText(uiEditableCombobox *c);
void uiEditableComboboxSetText(uiEditableCombobox *c, const char *text);
// TODO what do we call a function that sets the currently selected item and fills the text field with it? editable comboboxes have no consistent concept of selected item
void uiEditableComboboxOnChanged(uiEditableCombobox *c, void (*f)(uiEditableCombobox *c, void *data), void *data);
uiEditableCombobox *uiNewEditableCombobox(void);

// RadioButtons
typedef struct uiRadioButtons uiRadioButtons;
void uiRadioButtonsAppend(uiRadioButtons *r, const char *text);
int uiRadioButtonsSelected(uiRadioButtons *r);
void uiRadioButtonsSetSelected(uiRadioButtons *r, int n);
void uiRadioButtonsOnSelected(uiRadioButtons *r, void (*f)(uiRadioButtons *, void *), void *data);
uiRadioButtons *uiNewRadioButtons(void);

// DateTimePicker
struct tm
{
    int tm_sec;   // seconds after the minute - [0, 60] including leap second
    int tm_min;   // minutes after the hour - [0, 59]
    int tm_hour;  // hours since midnight - [0, 23]
    int tm_mday;  // day of the month - [1, 31]
    int tm_mon;   // months since January - [0, 11]
    int tm_year;  // years since 1900
    int tm_wday;  // days since Sunday - [0, 6]
    int tm_yday;  // days since January 1 - [0, 365]
    int tm_isdst; // daylight savings time flag
};
typedef struct uiDateTimePicker uiDateTimePicker;
// TODO document that tm_wday and tm_yday are undefined, and tm_isdst should be -1
// TODO document that for both sides
// TODO document time zone conversions or lack thereof
// TODO for Time: define what values are returned when a part is missing
void uiDateTimePickerTime(uiDateTimePicker *d, struct tm *time);
void uiDateTimePickerSetTime(uiDateTimePicker *d, const struct tm *time);
void uiDateTimePickerOnChanged(uiDateTimePicker *d, void (*f)(uiDateTimePicker *, void *), void *data);
uiDateTimePicker *uiNewDateTimePicker(void);
uiDateTimePicker *uiNewDatePicker(void);
uiDateTimePicker *uiNewTimePicker(void);

// MultilineEntry
// TODO provide a facility for entering tab stops?
typedef struct uiMultilineEntry uiMultilineEntry;
const char *uiMultilineEntryText(uiMultilineEntry *e);
void uiMultilineEntrySetText(uiMultilineEntry *e, const char *text);
void uiMultilineEntryAppend(uiMultilineEntry *e, const char *text);
void uiMultilineEntryOnChanged(uiMultilineEntry *e, void (*f)(uiMultilineEntry *e, void *data), void *data);
int uiMultilineEntryReadOnly(uiMultilineEntry *e);
void uiMultilineEntrySetReadOnly(uiMultilineEntry *e, int readonly);
uiMultilineEntry *uiNewMultilineEntry(void);
uiMultilineEntry *uiNewNonWrappingMultilineEntry(void);

// MenuItem
typedef struct uiMenuItem uiMenuItem;
void uiMenuItemEnable(uiMenuItem *m);
void uiMenuItemDisable(uiMenuItem *m);
void uiMenuItemOnClicked(uiMenuItem *m, void (*f)(uiMenuItem *sender, uiWindow *window, void *data), void *data);
int uiMenuItemChecked(uiMenuItem *m);
void uiMenuItemSetChecked(uiMenuItem *m, int checked);

// Menu
typedef struct uiMenu uiMenu;
uiMenuItem *uiMenuAppendItem(uiMenu *m, const char *name);
uiMenuItem *uiMenuAppendCheckItem(uiMenu *m, const char *name);
uiMenuItem *uiMenuAppendQuitItem(uiMenu *m);
uiMenuItem *uiMenuAppendPreferencesItem(uiMenu *m);
uiMenuItem *uiMenuAppendAboutItem(uiMenu *m);
void uiMenuAppendSeparator(uiMenu *m);
uiMenu *uiNewMenu(const char *name);

// Area
typedef struct uiArea uiArea;
typedef struct uiAreaHandler uiAreaHandler;
typedef struct uiAreaDrawParams uiAreaDrawParams;
typedef struct uiAreaMouseEvent uiAreaMouseEvent;
typedef struct uiAreaKeyEvent uiAreaKeyEvent;

typedef struct uiDrawContext uiDrawContext;

struct uiAreaHandler
{
    void (*Draw)(uiAreaHandler *, uiArea *, uiAreaDrawParams *);
    // TODO document that resizes cause a full redraw for non-scrolling areas; implementation-defined for scrolling areas
    void (*MouseEvent)(uiAreaHandler *, uiArea *, uiAreaMouseEvent *);
    // TODO document that on first show if the mouse is already in the uiArea then one gets sent with left=0
    // TODO what about when the area is hidden and then shown again?
    void (*MouseCrossed)(uiAreaHandler *, uiArea *, int left);
    void (*DragBroken)(uiAreaHandler *, uiArea *);
    int (*KeyEvent)(uiAreaHandler *, uiArea *, uiAreaKeyEvent *);
};
void uiAreaSetSize(uiArea *a, int width, int height);
// TODO uiAreaQueueRedraw()
void uiAreaQueueRedrawAll(uiArea *a);
void uiAreaScrollTo(uiArea *a, double x, double y, double width, double height);
// TODO document these can only be called within Mouse() handlers
// TODO should these be allowed on scrolling areas?
// TODO decide which mouse events should be accepted; Down is the only one guaranteed to work right now
// TODO what happens to events after calling this up to and including the next mouse up?
// TODO release capture?
void uiAreaBeginUserWindowMove(uiArea *a);
void uiAreaBeginUserWindowResize(uiArea *a, unsigned int edge);
uiArea *uiNewArea(uiAreaHandler *ah);
uiArea *uiNewScrollingArea(uiAreaHandler *ah, int width, int height);
struct uiAreaDrawParams
{
    uiDrawContext *Context;

    // TODO document that this is only defined for nonscrolling areas
    double AreaWidth;
    double AreaHeight;

    double ClipX;
    double ClipY;
    double ClipWidth;
    double ClipHeight;
};

// Draw
typedef struct uiDrawPath uiDrawPath;
typedef struct uiDrawBrush uiDrawBrush;
typedef struct uiDrawStrokeParams uiDrawStrokeParams;
typedef struct uiDrawMatrix uiDrawMatrix;

typedef struct uiDrawBrushGradientStop uiDrawBrushGradientStop;

struct uiDrawMatrix
{
    double M11;
    double M12;
    double M21;
    double M22;
    double M31;
    double M32;
};

struct uiDrawBrush
{
    int Type; // uiDrawBrushType

    // solid brushes
    double R;
    double G;
    double B;
    double A;

    // gradient brushes
    double X0;          // linear: start X, radial: start X
    double Y0;          // linear: start Y, radial: start Y
    double X1;          // linear: end X, radial: outer circle center X
    double Y1;          // linear: end Y, radial: outer circle center Y
    double OuterRadius; // radial gradients only
    uiDrawBrushGradientStop *Stops;
    unsigned long long NumStops;
    // TODO extend mode
    // cairo: none, repeat, reflect, pad; no individual control
    // Direct2D: repeat, reflect, pad; no individual control
    // Core Graphics: none, pad; before and after individually
    // TODO cairo documentation is inconsistent about pad

    // TODO images

    // TODO transforms
};

struct uiDrawBrushGradientStop
{
    double Pos;
    double R;
    double G;
    double B;
    double A;
};

struct uiDrawStrokeParams
{
    int Cap;  // uiDrawLineCap
    int Join; // uiDrawLineJoin
    int Join1;
    // TODO what if this is 0? on windows there will be a crash with dashing
    double Thickness;
    double MiterLimit;
    double *Dashes;
    // TOOD what if this is 1 on Direct2D?
    // TODO what if a dash is 0 on Cairo or Quartz?
    unsigned long long NumDashes;
    double DashPhase;
};

uiDrawPath *uiDrawNewPath(int fillMode); // uiDrawFillMode
void uiDrawFreePath(uiDrawPath *p);

void uiDrawPathNewFigure(uiDrawPath *p, double x, double y);
void uiDrawPathNewFigureWithArc(uiDrawPath *p, double xCenter, double yCenter, double radius, double startAngle, double sweep, int negative);
void uiDrawPathLineTo(uiDrawPath *p, double x, double y);
// notes: angles are both relative to 0 and go counterclockwise
// TODO is the initial line segment on cairo and OS X a proper join?
// TODO what if sweep < 0?
void uiDrawPathArcTo(uiDrawPath *p, double xCenter, double yCenter, double radius, double startAngle, double sweep, int negative);
void uiDrawPathBezierTo(uiDrawPath *p, double c1x, double c1y, double c2x, double c2y, double endX, double endY);
// TODO quadratic bezier
void uiDrawPathCloseFigure(uiDrawPath *p);

// TODO effect of these when a figure is already started
void uiDrawPathAddRectangle(uiDrawPath *p, double x, double y, double width, double height);

void uiDrawPathEnd(uiDrawPath *p);

void uiDrawStroke(uiDrawContext *c, uiDrawPath *path, uiDrawBrush *b, uiDrawStrokeParams *p);
void uiDrawFill(uiDrawContext *c, uiDrawPath *path, uiDrawBrush *b);

void uiDrawMatrixSetIdentity(uiDrawMatrix *m);
void uiDrawMatrixTranslate(uiDrawMatrix *m, double x, double y);
void uiDrawMatrixScale(uiDrawMatrix *m, double xCenter, double yCenter, double x, double y);
void uiDrawMatrixRotate(uiDrawMatrix *m, double x, double y, double amount);
void uiDrawMatrixSkew(uiDrawMatrix *m, double x, double y, double xamount, double yamount);
void uiDrawMatrixMultiply(uiDrawMatrix *dest, uiDrawMatrix *src);
int uiDrawMatrixInvertible(uiDrawMatrix *m);
int uiDrawMatrixInvert(uiDrawMatrix *m);
void uiDrawMatrixTransformPoint(uiDrawMatrix *m, double *x, double *y);
void uiDrawMatrixTransformSize(uiDrawMatrix *m, double *x, double *y);

void uiDrawTransform(uiDrawContext *c, uiDrawMatrix *m);

// TODO add a uiDrawPathStrokeToFill() or something like that
void uiDrawClip(uiDrawContext *c, uiDrawPath *path);

void uiDrawSave(uiDrawContext *c);
void uiDrawRestore(uiDrawContext *c);

// Attribute
typedef struct uiAttribute uiAttribute;
void uiFreeAttribute(uiAttribute *a);
int uiAttributeGetType(const uiAttribute *a); // uiAttributeType
uiAttribute *uiNewFamilyAttribute(char *family);
const char *uiAttributeFamily(const uiAttribute *a);
uiAttribute *uiNewSizeAttribute(double size);
double uiAttributeSize(const uiAttribute *a);
uiAttribute *uiNewWeightAttribute(int weight);   // uiTextWeight
int uiAttributeWeight(const uiAttribute *a);     // uiTextWeight
uiAttribute *uiNewItalicAttribute(int italic);   // uiTextItalic
int uiAttributeItalic(const uiAttribute *a);     // uiTextItalic
uiAttribute *uiNewStretchAttribute(int stretch); // uiTextStretch
int uiAttributeStretch(const uiAttribute *a);    // uiTextStretch
uiAttribute *uiNewColorAttribute(double r, double g, double b, double a);
void uiAttributeColor(const uiAttribute *a, double *r, double *g, double *b, double *alpha);
uiAttribute *uiNewBackgroundAttribute(double r, double g, double b, double a);
uiAttribute *uiNewUnderlineAttribute(int u);                                                                  // uiUnderline
int uiAttributeUnderline(const uiAttribute *a);                                                               // uiUnderline
uiAttribute *uiNewUnderlineColorAttribute(int u, double r, double g, double b, double a);                     // uiUnderlineColor
void uiAttributeUnderlineColor(const uiAttribute *a, int *u, double *r, double *g, double *b, double *alpha); // uiUnderlineColor

typedef struct uiAttributedString uiAttributedString;
typedef int (*uiAttributedStringForEachAttributeFunc)(const uiAttributedString *s, const uiAttribute *a, unsigned long long start, unsigned long long end, void *data);
uiAttributedString *uiNewAttributedString(const char *initialString);
void uiFreeAttributedString(uiAttributedString *s);
const char *uiAttributedStringString(const uiAttributedString *s);
unsigned long long uiAttributedStringLen(const uiAttributedString *s);
void uiAttributedStringAppendUnattributed(uiAttributedString *s, const char *str);
void uiAttributedStringInsertAtUnattributed(uiAttributedString *s, const char *str, unsigned long long at);
void uiAttributedStringDelete(uiAttributedString *s, unsigned long long start, unsigned long long end);
void uiAttributedStringSetAttribute(uiAttributedString *s, uiAttribute *a, unsigned long long start, unsigned long long end);
void uiAttributedStringForEachAttribute(const uiAttributedString *s, uiAttributedStringForEachAttributeFunc f, void *data);
// TODO const correct this somehow (the implementation needs to mutate the structure)
unsigned long long uiAttributedStringNumGraphemes(uiAttributedString *s);
// TODO const correct this somehow (the implementation needs to mutate the structure)
unsigned long long uiAttributedStringByteIndexToGrapheme(uiAttributedString *s, unsigned long long pos);
// TODO const correct this somehow (the implementation needs to mutate the structure)
unsigned long long uiAttributedStringGraphemeToByteIndex(uiAttributedString *s, unsigned long long pos);

// Features
typedef struct uiOpenTypeFeatures uiOpenTypeFeatures;
typedef int (*uiOpenTypeFeaturesForEachFunc)(const uiOpenTypeFeatures *otf, char a, char b, char c, char d, unsigned int value, void *data);
uiOpenTypeFeatures *uiNewOpenTypeFeatures(void);
void uiFreeOpenTypeFeatures(uiOpenTypeFeatures *otf);
uiOpenTypeFeatures *uiOpenTypeFeaturesClone(const uiOpenTypeFeatures *otf);
void uiOpenTypeFeaturesAdd(uiOpenTypeFeatures *otf, char a, char b, char c, char d, unsigned int value);
void uiOpenTypeFeaturesRemove(uiOpenTypeFeatures *otf, char a, char b, char c, char d);
int uiOpenTypeFeaturesGet(const uiOpenTypeFeatures *otf, char a, char b, char c, char d, unsigned int *value);
void uiOpenTypeFeaturesForEach(const uiOpenTypeFeatures *otf, uiOpenTypeFeaturesForEachFunc f, void *data);
uiAttribute *uiNewFeaturesAttribute(const uiOpenTypeFeatures *otf);
const uiOpenTypeFeatures *uiAttributeFeatures(const uiAttribute *a);

typedef struct uiFontDescriptor uiFontDescriptor;
struct uiFontDescriptor
{
    // TODO const-correct this or figure out how to deal with this when getting a value
    char *Family;
    double Size;
    int Weight;
    int Italic;
    int Stretch;
};
void uiLoadControlFont(uiFontDescriptor *f);
void uiFreeFontDescriptor(uiFontDescriptor *desc);
typedef struct uiDrawTextLayout uiDrawTextLayout;
typedef struct uiDrawTextLayoutParams uiDrawTextLayoutParams;
struct uiDrawTextLayoutParams
{
    uiAttributedString *String;
    uiFontDescriptor *DefaultFont;
    double Width;
    int Align;
};
uiDrawTextLayout *uiDrawNewTextLayout(uiDrawTextLayoutParams *params);
void uiDrawFreeTextLayout(uiDrawTextLayout *tl);
void uiDrawText(uiDrawContext *c, uiDrawTextLayout *tl, double x, double y);
void uiDrawTextLayoutExtents(uiDrawTextLayout *tl, double *width, double *height);

typedef struct uiFontButton uiFontButton;
void uiFontButtonFont(uiFontButton *b, uiFontDescriptor *desc);
void uiFontButtonOnChanged(uiFontButton *b, void (*f)(uiFontButton *, void *), void *data);
uiFontButton *uiNewFontButton(void);
void uiFreeFontButtonFont(uiFontDescriptor *desc);

struct uiAreaMouseEvent
{
    // TODO document what these mean for scrolling areas
    double X;
    double Y;

    // TODO see draw above
    double AreaWidth;
    double AreaHeight;

    int Down;
    int Up;

    int Count;

    int Modifiers;

    unsigned long long Held1To64;
};

struct uiAreaKeyEvent
{
    char Key;
    int ExtKey;
    int Modifier;

    int Modifiers;

    int Up;
};

typedef struct uiColorButton uiColorButton;
#define uiColorButton(this) ((uiColorButton *)(this))
void uiColorButtonColor(uiColorButton *b, double *r, double *g, double *bl, double *a);
void uiColorButtonSetColor(uiColorButton *b, double r, double g, double bl, double a);
void uiColorButtonOnChanged(uiColorButton *b, void (*f)(uiColorButton *, void *), void *data);
uiColorButton *uiNewColorButton(void);

// Form
typedef struct uiForm uiForm;
void uiFormAppend(uiForm *f, const char *label, uiControl *c, int stretchy);
int uiFormNumChildren(uiForm *f);
void uiFormDelete(uiForm *f, int index);
int uiFormPadded(uiForm *f);
void uiFormSetPadded(uiForm *f, int padded);
uiForm *uiNewForm(void);

// Grid
typedef struct uiGrid uiGrid;
#define uiGrid(this) ((uiGrid *)(this))
void uiGridAppend(uiGrid *g, uiControl *c, int left, int top, int xspan, int yspan, int hexpand, int halign, int vexpand, int valign);             // uiAlign
void uiGridInsertAt(uiGrid *g, uiControl *c, uiControl *existing, int at, int xspan, int yspan, int hexpand, int halign, int vexpand, int valign); // uiAlign uiAt
int uiGridPadded(uiGrid *g);
void uiGridSetPadded(uiGrid *g, int padded);
uiGrid *uiNewGrid(void);

// Image
typedef struct uiImage uiImage;
uiImage *uiNewImage(double width, double height);
void uiFreeImage(uiImage *i);
void uiImageAppend(uiImage *i, void *pixels, int pixelWidth, int pixelHeight, int byteStride);

// Table
typedef struct uiTableValue uiTableValue;
void uiFreeTableValue(uiTableValue *v);
int uiTableValueGetType(const uiTableValue *v); // uiTableValueType
uiTableValue *uiNewTableValueString(const char *str);
const char *uiTableValueString(const uiTableValue *v);
uiTableValue *uiNewTableValueImage(uiImage *img);
uiImage *uiTableValueImage(const uiTableValue *v);
uiTableValue *uiNewTableValueInt(int i);
int uiTableValueInt(const uiTableValue *v);
uiTableValue *uiNewTableValueColor(double r, double g, double b, double a);
void uiTableValueColor(const uiTableValue *v, double *r, double *g, double *b, double *a);
typedef struct uiTableModel uiTableModel;
typedef struct uiTableModelHandler uiTableModelHandler;
struct uiTableModelHandler
{
    int (*NumColumns)(uiTableModelHandler *, uiTableModel *);
    int (*ColumnType)(uiTableModelHandler *, uiTableModel *, int); // uiTableValueType
    int (*NumRows)(uiTableModelHandler *, uiTableModel *);
    uiTableValue *(*CellValue)(uiTableModelHandler *mh, uiTableModel *m, int row, int column);
    void (*SetCellValue)(uiTableModelHandler *, uiTableModel *, int, int, const uiTableValue *);
};
uiTableModel *uiNewTableModel(uiTableModelHandler *mh);
void uiFreeTableModel(uiTableModel *m);
void uiTableModelRowInserted(uiTableModel *m, int newIndex);
void uiTableModelRowChanged(uiTableModel *m, int index);
void uiTableModelRowDeleted(uiTableModel *m, int oldIndex);
typedef struct uiTableTextColumnOptionalParams uiTableTextColumnOptionalParams;
typedef struct uiTableParams uiTableParams;
struct uiTableTextColumnOptionalParams
{
    int ColorModelColumn;
};
struct uiTableParams
{
    uiTableModel *Model;
    int RowBackgroundColorModelColumn;
};

// Table
typedef struct uiTable uiTable;
void uiTableAppendTextColumn(uiTable *t,
                             const char *name,
                             int textModelColumn,
                             int textEditableModelColumn,
                             uiTableTextColumnOptionalParams *textParams);
void uiTableAppendImageColumn(uiTable *t,
                              const char *name,
                              int imageModelColumn);
void uiTableAppendImageTextColumn(uiTable *t,
                                  const char *name,
                                  int imageModelColumn,
                                  int textModelColumn,
                                  int textEditableModelColumn,
                                  uiTableTextColumnOptionalParams *textParams);
void uiTableAppendCheckboxColumn(uiTable *t,
                                 const char *name,
                                 int checkboxModelColumn,
                                 int checkboxEditableModelColumn);
void uiTableAppendCheckboxTextColumn(uiTable *t,
                                     const char *name,
                                     int checkboxModelColumn,
                                     int checkboxEditableModelColumn,
                                     int textModelColumn,
                                     int textEditableModelColumn,
                                     uiTableTextColumnOptionalParams *textParams);
void uiTableAppendProgressBarColumn(uiTable *t,
                                    const char *name,
                                    int progressModelColumn);
void uiTableAppendButtonColumn(uiTable *t,
                               const char *name,
                               int buttonModelColumn,
                               int buttonClickableModelColumn);
int uiTableHeaderVisible(uiTable *t);
void uiTableHeaderSetVisible(uiTable *t, int visible);
uiTable *uiNewTable(uiTableParams *params);
void uiTableOnRowClicked(uiTable *t, void (*f)(uiTable *t, int row, void *data), void *data);
void uiTableOnRowDoubleClicked(uiTable *t, void (*f)(uiTable *t, int row, void *data), void *data);
void uiTableHeaderSetSortIndicator(uiTable *t, int column, int indicator); // uiSortIndicator
int uiTableHeaderSortIndicator(uiTable *t, int column); // uiSortIndicator
void uiTableHeaderOnClicked(uiTable *t, void (*f)(uiTable *sender, int column, void *senderData), void *data);
int uiTableColumnWidth(uiTable *t, int column);
void uiTableColumnSetWidth(uiTable *t, int column, int width);
int uiTableGetSelectionMode(uiTable *t); // uiTableSelectionMode
void uiTableSetSelectionMode(uiTable *t, int mode); // uiTableSelectionMode
void uiTableOnSelectionChanged(uiTable *t, void (*f)(uiTable *t, void *data), void *data);

typedef struct uiTableSelection uiTableSelection;
struct uiTableSelection
{
	int NumRows; //!< Number of selected rows.
	int *Rows;   //!< Array containing selected row indices, NULL on empty selection.
};
uiTableSelection* uiTableGetSelection(uiTable *t);
void uiTableSetSelection(uiTable *t, uiTableSelection *sel);
void uiFreeTableSelection(uiTableSelection* s);